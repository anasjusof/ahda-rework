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

        $vehicles = vehicle::all();
        $approved = booking_history::where('approval', '=', '1')->get();
        $rejected = booking_history::where('approval', '=', '2')->get();
        $pending = booking_history::where('approval', '=', '0')->get();

        return view('admin.dashboard', compact('vehicles', 'approved', 'rejected', 'pending'));
    }

    ####################### User ###########################

    public function manageUser(){
    	$users = User::paginate(5);

    	return view('admin.manage-user', compact('users'));
    }

    public function createUser(UserRequest $request){

        $input = $request->except('password_confirmation');

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        return redirect()->back()->with('create_message', 'User successfully created!');

    }

    public function editUser(UserRequest $request){
        $input = $request->except('password_confirmation');

        if($input['roles_id'] == 1){
            $input['faculties_id'] = 0;
        }
        $user = User::findOrFail($input['id']);

        $user->name = $input['name'];

        if(!empty($input['password'])){
            $user->password = bcrypt($input['password']);
        }
        
        $user->roles_id = $input['roles_id'];
        $user->faculty = $input['faculty'];
        $user->phone = $input['phone'];
        $user->matrik = $input['matrik'];

        $user->save();

        return redirect()->back()->with('update_message', 'User info successfully updated!');
    }

    ####################### Vehicles ###########################

	public function deleteVechicle(Request $request){

        foreach($request->users_id as $id){
            $user = User::findOrFail($id);

            $user->delete();
        }

        return redirect()->back()->with('create_message', 'User successfully deleted!');

    }

    public function manageVehicle(){
        $vehicles = vehicle::paginate(5);

        return view('admin.manage-vehicle', compact('vehicles'));
    }

    public function createVehicle(Request $request){
        $input = $request->all();

        $vehicle = vehicle::create($input);

        return redirect()->back()->with('create_message', 'Vehicle successfully created!');
    }

    public function editVehicle(Request $request){
        $input = $request->all();

        $vehicle = vehicle::findOrFail($input['id']);

        $vehicle->model = $input['model'];
        $vehicle->plate = $input['plate'];
        $vehicle->type = $input['type'];

        $vehicle->save();

        return redirect()->back()->with('update_message', 'Vehicle info successfully updated!');
    }

    public function deleteVehicle(Request $request){
        $vehicles = vehicle::findOrFail($request->vehicle_id);

        foreach($vehicles as $vehicle){
            $vehicle->delete();
        }

        return redirect()->back()->with('delete_message', 'Vehicle successfully deleted!');

    }

    public function viewVehicleHistories($vehicle_id){

        $directory = '/attachment/';

        $vehicle = vehicle::find($vehicle_id);

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

        $checkSearch = 0;

        $queries = [];

        $directory = '/attachment/';

        $histories = booking_history::select('users.name', 'users.email', 'users.matrik', 'users.phone', 'users.faculty', 'booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.purpose', 'attachments.filepath', 'vehicles.model', 'vehicles.plate', 'vehicles.type')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->join('vehicles', 'vehicles.id', '=', 'booking_histories.car_id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id');

        if(request()->has('status')){

            $histories = $histories->where('booking_histories.approval', '=', request('status'));

            $queries['status'] = request('status');

            $checkSearch++;
        }

        if($checkSearch == 0){

            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5);

            return view('admin.manage-booking', compact('histories', 'directory')); 
        }

        else{
            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5)->appends($queries);

            return view('admin.manage-booking', compact('histories', 'directory')); 
        }
    }

    public function approveReject(Request $request){
        $request->all();

        foreach($request->history as $history){

            $pieces = explode("-", $history);
            $history_id = $pieces[0];
            $status = $pieces[1];

            $histories = booking_history::find($history_id);

            $histories->approval = $status;

            $histories->save();

        }

        return redirect()->back();
    }

}
