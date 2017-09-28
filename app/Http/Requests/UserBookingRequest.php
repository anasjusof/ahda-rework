<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserBookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method() == 'POST')
        {
            return [
                'purpose'=>'required',
                'start_date'=>'required',
                'end_date'=>'required',
                'attachment'=>'required',
                'car_id' =>'required'
            ];
        }
    }

    public function messages(){

        return [
            'purpose.required'=>'Please state purpose of booking',
            'start_date.required'=>'Please select start date',
            'end_date.required'=>'Please select end date',
            'attachment.required'=>'Please upload relevant attachment',
            'car_id.required'=>'Please select vehicle to be booked',
        ];
    }

    public function response(array $errors){
        return \Redirect::route('user.index')->withErrors($errors)->withInput();
    }
}
