<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\LecturerRequest;

use Auth;
use DB;

use App\LecturerHistory;
use App\Attachment;
use App\booking_history;

class LecturerController extends Controller
{
    public function homepage(){
        return view('homepage');
    }

    public function index(){

        $histories = booking_history::select('users.name', 'users.email','booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.purpose', 'attachments.filepath', 'vehicles.model')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->join('vehicles', 'vehicles.id', '=', 'booking_histories.car_id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id')
            ->where('users.id', '=', Auth::user()->id);

        $checkSearch = 0;

        $queries = [];

        $columns = [
            'booking_histories.approval'
        ];

        $directory = '/attachment/';

        if(request()->has('status')){

            $histories = $histories->where('booking_histories.approval', '=', request('status'));

            $queries['status'] = request('status');

            $checkSearch++;
        }


        if($checkSearch == 0){
            echo $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5);

            response()->json(array('check'=>$histories));

            return view('pensyarah.index', compact('histories', 'directory'));

        }
        else{

            $histories = $histories->orderBy('booking_histories.id', 'DESC')
                                    ->paginate(5)->appends($queries);

            return $html = view('pensyarah.index', compact('histories', 'directory'));
        }

    }

    public function booking(Request $request){

        $input = $request->all();

        //Store receipt
        if(!empty($input['attachment'])){

            $file = $input['attachment'];

            $name = time() . $file->getClientOriginalName();

            $file->move('attachment', $name);

            $attachment = Attachment::create(['filepath'=>$name]);

            $input['attachment_id'] = $attachment->id;
        }

        $start_date = strtotime($input['start_date']);
        $start_date = date('Y-m-d',$start_date);

        $end_date = strtotime($input['end_date']);
        $end_date = date('Y-m-d',$end_date);
        // print_r($input); exit;
        $input['start_date'] = $input['start_date'];
        $input['end_date'] = $input['end_date'];
        $input['user_id'] = Auth::user()->id;
        $input['car_id'] = $input['car_id'];
        $input['destination'] = $input['destination'];
        $input['purpose'] = $input['purpose'];
        $input['remarks'] = '';
        $input['approval'] = 0;

        //Store history info

        $history = booking_history::create($input);

        return redirect()->route('pensyarah.index')->with('message', 'Your booking is successful! Please wait for admin approval!');
    }

    public function showAvailableBooking(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $directory = '/attachment/';

        //Select vehicle that in not in booking range and approval status is rejected
        $available_bookings = DB::select(DB::raw('SELECT vehicles.* FROM `vehicles` 
                                                    LEFT JOIN booking_histories
                                                    ON vehicles.id = booking_histories.car_id
                                                    WHERE vehicles.id
                                                    NOT IN 
                                                    (
                                                        SELECT booking_histories.car_id FROM booking_histories
                                                        WHERE
                                                        (
                                                            booking_histories.start_date <= "'.$request->end_date.'"
                                                            AND 
                                                            booking_histories.end_date >= "'.$request->start_date.'"
                                                        )
                                                        AND
                                                        (booking_histories.approval = 0 OR booking_histories.approval = 1)
                                                    )'));
        //print_r($available_bookings);

        return view('pensyarah.booking', compact('available_bookings', 'directory', 'start_date', 'end_date'));
    }
}