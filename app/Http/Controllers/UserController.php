<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserBookingRequest;

use Auth;
use DB;

use App\Attachment;
use App\booking_history;

class UserController extends Controller
{
    #This function is to return the /test
    public function test(){
        return view('test');
    }

    #This function is to return the /homepage
    public function homepage(){
        return view('homepage');
    }

    #This function is to return the page /check-availability
    public function checkAvailability(){
        return view('checkAvailability');
    }

    #This function is to return the availibility of booking
    public function check(Request $request){
        //Get request of dates
        $input = $request->all();

        //Convert start and end date to date format
        $start_date = strtotime($input['start_date']);
        $start_date = date('Y-m-d',$start_date);

        $end_date = strtotime($input['end_date']);
        $end_date = date('Y-m-d',$end_date);

        #Query to join two table, vehicles and booking history
        #Select only vehicle that NOT IN booked date AND approval is 0[Pending] and 1[Approved] P.S / You cant booked vehicle that already in pending and approved status, but only on rejected status
        $available_bookings = DB::select(DB::raw("SELECT vehicles.* FROM `vehicles` 
                                                    LEFT JOIN booking_histories
                                                    ON vehicles.id = booking_histories.car_id
                                                    WHERE vehicles.id
                                                    NOT IN 
                                                    (
                                                        SELECT booking_histories.car_id FROM booking_histories
                                                        WHERE
                                                        (
                                                            (booking_histories.start_date <= '$start_date' AND booking_histories.end_date >= '$start_date') OR 
                                                            (booking_histories.start_date <= '$end_date' AND booking_histories.end_date >= '$end_date') OR 
                                                            (booking_histories.start_date >= '$start_date' AND booking_histories.end_date <= '$end_date')
                                                        )
                                                        AND
                                                        (booking_histories.approval = 0 OR booking_histories.approval = 1)
                                                    )
                                                    GROUP BY vehicles.id"));
        
        return view('check', compact('available_bookings'));
    }

    public function index(){

        //Query to select booking history based on current logged on user id
        $histories = booking_history::select('users.name', 'users.email','booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.remarks', 'booking_histories.purpose', 'attachments.filepath', 'vehicles.model')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->leftJoin('vehicles', 'vehicles.id', '=', 'booking_histories.car_id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id')
            ->where('users.id', '=', Auth::user()->id);

        //Variable to check if there's search/filter
        $checkSearch = 0;
        $queries = [];
        $columns = [
            'booking_histories.approval'
        ];

        //Directory of attachment @ thisprojecttitle/public/attachment/
        $directory = '/attachment/';

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
            echo $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5);

            response()->json(array('check'=>$histories));

            return view('user.index', compact('histories', 'directory'));

        }
        //Else, append the query of search/filter
        else{

            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5)->appends($queries);

            return $html = view('user.index', compact('histories', 'directory'));
        }

    }

    #UserBookingRequest can be found at app/Http/Requests/UserBookingRequest.php @ custom request validation
    public function booking(UserBookingRequest $request){
        //Get all request and store in variable
        $input = $request->all();

        //Store receipt
        //If attachment is not empty
        if(!empty($input['attachment'])){

            $file = $input['attachment'];

            //Add time to original name of file to make it unique
            $name = time() . $file->getClientOriginalName();

            //Move the file to the directory attachment @ thisprojecttitle/public/attachment/
            $file->move('attachment', $name);

            //create attachement info on DB @ attachment_name
            $attachment = Attachment::create(['filepath'=>$name]);

            //Store attachment_id in $input to be stored in booking_history
            $input['attachment_id'] = $attachment->id;
        }


        //Convert start date and end date to date format
        $start_date = strtotime($input['start_date']);
        $start_date = date('Y-m-d',$start_date);

        $end_date = strtotime($input['end_date']);
        $end_date = date('Y-m-d',$end_date);
        
        //Store array with value required on DB
        $input['start_date'] = $input['start_date'];
        $input['end_date'] = $input['end_date'];
        $input['user_id'] = Auth::user()->id;
        $input['car_id'] = 0;
        $input['destination'] = $input['destination'];
        $input['purpose'] = $input['purpose'];
        $input['remarks'] = '';
        $input['total_passenger'] = $input['total_passenger'];
        $input['approval'] = 0;

        //Store history info
        $history = booking_history::create($input);

        return redirect()->route('user.index')->with('message', 'Your booking is successful! Please wait for admin approval!');
    }

    public function showAvailableBooking(Request $request){

        //Get start date and end date
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        //Directory of attachment @ thisprojecttitle/public/attachment/
        $directory = '/attachment/';

        #Query to join two table, vehicles and booking history
        #Select only vehicle that NOT IN booked date AND approval is 0[Pending] and 1[Approved] P.S / You cant booked vehicle that already in pending and approved status, but only on rejected status
        $available_bookings = DB::select(DB::raw("SELECT vehicles.* FROM `vehicles` 
                                                    LEFT JOIN booking_histories
                                                    ON vehicles.id = booking_histories.car_id
                                                    WHERE vehicles.id
                                                    NOT IN 
                                                    (
                                                        SELECT booking_histories.car_id FROM booking_histories
                                                        WHERE
                                                        (
                                                            booking_histories.start_date <= '$start_date'
                                                            AND 
                                                            booking_histories.end_date >= '$end_date'
                                                        )
                                                        AND
                                                        (booking_histories.approval = 0 OR booking_histories.approval = 1)
                                                    )
                                                    GROUP BY vehicles.id"));

        return view('user.booking', compact('available_bookings', 'directory', 'start_date', 'end_date'));
    }
}