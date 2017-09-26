<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\LecturerRequest;

use Auth;

use App\LecturerHistory;
use App\Attachment;
use App\booking_history;

class LecturerController extends Controller
{
    public function index(){

        $histories = booking_history::select('users.name', 'users.email','booking_histories.id as history_id', 'booking_histories.start_date','booking_histories.end_date','booking_histories.created_at', 'booking_histories.approval', 'booking_histories.destination', 'booking_histories.purpose', 'attachments.filepath')
            ->leftJoin('users', 'booking_histories.user_id', '=', 'users.id')
            ->join('attachments', 'booking_histories.attachment_id', '=', 'attachments.id')
            ->where('users.id', '=', Auth::user()->id);

        $checkSearch = 0;

        $queries = [];

        $columns = [
            'booking_histories.approval'
        ];

        $directory = '/images/';

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

    public function applyLeave(LecturerRequest $request){

        $input = $request->all();

        //Store receipt
        if(!empty($input['attachment'])){

            $file = $input['attachment'];

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $attachment = Attachment::create(['filepath'=>$name]);

            $input['attachments_id'] = $attachment->id;
        }

        $date_to = strtotime($input['date_to']);
        $date_to = date('Y-m-d',$date_to);

        $date_from = strtotime($input['date_from']);
        $date_from = date('Y-m-d',$date_from);

        $input['start_date'] = $date_to;
        $input['end_date'] = $date_from;
        $input['user_id'] = Auth::user()->id;
        $input['car_id'] = $input['car_id'];
        $input['destination'] = $input['destination'];
        $input['purpose'] = $input['purpose'];
        $input['remarks'] = '';
        $input['approval'] = 0;

        //Store history info

        $history = LecturerHistory::create($input);

        return redirect()->back()->with('message', 'Your booking is successful! Please wait for admin approval!');
    }
}