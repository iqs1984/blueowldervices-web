<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CustomerRequest;
use Validator;

class CustomerController extends Controller
{
    //
	public function customerrequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'price' => 'required',
			'question_id' => 'required',
			'location_id' => 'required',
        ]);
		if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }
		
		try {
            $customer_request = CustomerRequest::make();
			$customer_request->name = $request->name;
			$customer_request->email = $request->email;
			$customer_request->phone = $request->phone;
			$customer_request->price = $request->price;
			$customer_request->question_id = $request->question_id;
			$customer_request->location_id = $request->location_id;
			$customer_request->save();
			return response()->json(['status' => 'Yes', 'message' => 'We have received your query.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
		
	}
	
	public function enquirylist(Request $request)
	{
	    if($request->id){
	    $enquirylist = CustomerRequest::with('services','location')->where('status',$request->id)->get();
	    }else{
	    $enquirylist = CustomerRequest::with('services','location')->get();
	    }

        if (count($enquirylist) > 0) {
            return response()->json(['status' => 'Yes', 'data' => $enquirylist]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Enquiry not found.']);
        }
	}
	
	public function markcomplete(Request $request)
	{
	    $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
		if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }
		
		try {
            $mark_complete = CustomerRequest::find($request->id);
			$mark_complete->status = '1';
			$mark_complete->save();
			return response()->json(['status' => 'Yes', 'message' => 'Complete'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
	}
	
	
}
