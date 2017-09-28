<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;

use App\User;
use App\vehicle;
use App\booking_history;

class AdminController extends Controller
{
    public function index(){

        //Select total vehicles, total book approved, rejected and pending
        $vehicles = vehicle::all();
        $approved = booking_history::where('approval', '=', '1')->get();
        $rejected = booking_history::where('approval', '=', '2')->get();
        $pending = booking_history::where('approval', '=', '0')->get();

        return view('admin.dashboard', compact('vehicles', 'approved', 'rejected', 'pending'));
    }

    ####################### User ###########################

    public function manageUser(){

        //Select user and paginate by 5
    	$users = User::paginate(5);

    	return view('admin.manage-user', compact('users'));
    }

    public function createUser(UserRequest $request){

        //Get all request except password_confirmation and store into input variable 
        $input = $request->except('password_confirmation');

        //Bcrypt user password
        $input['password'] = bcrypt($input['password']);

        //Create user
        $user = User::create($input);

        return redirect()->back()->with('create_message', 'User successfully created!');

    }

    public function editUser(UserRequest $request){
        //Get all request except password_confirmation and store into input variable 
        $input = $request->except('password_confirmation');

        //Find user based on id
        $user = User::findOrFail($input['id']);

        
        //If not empty user password then only update user password
        if(!empty($input['password'])){
            $user->password = bcrypt($input['password']);
        }
        
        //Store array with value required on DB
        $user->name = $input['name'];
        $user->roles_id = $input['roles_id'];
        $user->faculty = $input['faculty'];
        $user->phone = $input['phone'];
        $user->matrik = $input['matrik'];

        //Save the user updated info
        $user->save();

        return redirect()->back()->with('update_message', 'User info successfully updated!');
    }

    public function deleteUser(Request $request){

        //Foreach user id selected
        foreach($request->users_id as $id){

            //Find user based on id
            $user = User::findOrFail($id);

            //Find vehicle history of user {This is to prevent query error if user deleted, but the user info is still in the booking_history table}
            $vehicle_histories = booking_history::where('user_id', '=', $user->id)->get();

            //If there's any record of booking history, then only delete. 
            if(count($vehicle_histories) > 0){

                //Foreach booking history, delete
                foreach($vehicle_histories as $vehicle_history){
                    $vehicle_history->delete();
                }
            }
            
            //Delete user
            $user->delete();
        }
        return redirect()->back()->with('create_message', 'User successfully deleted!');
    }

    ####################### Vehicles ###########################

    public function manageVehicle(){
        //Select vehicles and paginate by 5
        $vehicles = vehicle::paginate(5);

        return view('admin.manage-vehicle', compact('vehicles'));
    }

    public function createVehicle(Request $request){
        //Get all send request and store into variable
        $input = $request->all();

        //Create vehicle based on input 
        $vehicle = vehicle::create($input);

        return redirect()->back()->with('create_message', 'Vehicle successfully created!');
    }

    public function editVehicle(Request $request){
        //Get all request and store into variable
        $input = $request->all();

        //Find vehicle info based on vehicle id
        $vehicle = vehicle::findOrFail($input['id']);

        //Store array with value required on DB
        $vehicle->model = $input['model'];
        $vehicle->plate = $input['plate'];
        $vehicle->type = $input['type'];

        //Save the vehicle updated info
        $vehicle->save();

        return redirect()->back()->with('update_message', 'Vehicle info successfully updated!');
    }

    public function deleteVehicle(Request $request){

        //Find vehicle based on vehicle id
        $vehicles = vehicle::findOrFail($request->vehicle_id);


        foreach($vehicles as $vehicle){
            //Find vehicle history of user {This is to prevent query error if user deleted, but the user info is still in the booking_history table}
            $vehicle_histories = booking_history::where('car_id', '=', $vehicle->id)->get();

            //If there's any record of booking history, then only delete. 
            if(count($vehicle_histories) > 0){

                //Foreach vehicle histories, then delete
                foreach($vehicle_histories as $vehicle_history){
                    $vehicle_history->delete();
                }
            }

            //Delete vehicle
            $vehicle->delete();
        }

        return redirect()->back()->with('delete_message', 'Vehicle successfully deleted!');

    }

    public function viewVehicleHistories($vehicle_id){

        //Directory of attachment @ thisprojecttitle/public/attachment/
        $directory = '/attachment/';

        //Find vehicle based on vehicle id
        $vehicle = vehicle::find($vehicle_id);

        //Get all booking history of vehicle based on vehicle id
        $histories = booking_history::select('users.name', 'users.email','booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.purpose', 'attachments.filepath', 'vehicles.model')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->join('vehicles', 'vehicles.id', '=', 'booking_histories.car_id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id');

        $histories = $histories->where('booking_histories.car_id', $vehicle_id)
                                ->orderBy('booking_histories.id', 'DESC')
                                ->paginate(5);

        return view('admin.view-vehicle-history', compact('histories', 'directory', 'vehicle')); 
        
    }

    ####################### Booking ###########################

    public function manageBooking(){
        //Variable to check if there's search/filter
        $checkSearch = 0;
        $queries = [];

        //Directory of attachment @ thisprojecttitle/public/attachment/
        $directory = '/attachment/';

        //Get all booking histories info
        $histories = booking_history::select('users.name', 'users.email', 'users.matrik', 'users.phone', 'users.faculty', 'booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.purpose', 'attachments.filepath', 'vehicles.model', 'vehicles.plate', 'vehicles.type')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->join('vehicles', 'vehicles.id', '=', 'booking_histories.car_id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id');

        //If request has status @ filter
        if(request()->has('status')){
            //Add query where approval = searched status
            $histories = $histories->where('booking_histories.approval', '=', request('status'));

            $queries['status'] = request('status');

            //Increase the count of check search to record there's search in request
            $checkSearch++;
        }

        //If no search/filter, then apply this query
        if($checkSearch == 0){

            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5);

            return view('admin.manage-booking', compact('histories', 'directory')); 
        }
        //Else, append the query of search/filter
        else{
            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5)->appends($queries);

            return view('admin.manage-booking', compact('histories', 'directory')); 
        }
    }

    public function approveReject(Request $request){
        //Get all request 
        $request->all();

        //Foreach request history selected
        foreach($request->history as $history){

            //Explode the string of request history
            $pieces = explode("-", $history);

            //first array is history id
            $history_id = $pieces[0];

            //second array is history status
            $status = $pieces[1];

            //Find history based on history_id
            $histories = booking_history::find($history_id);

            //Update the approval status based on request status
            $histories->approval = $status;

            //Save
            $histories->save();

        }

        return redirect()->back();
    }

}
