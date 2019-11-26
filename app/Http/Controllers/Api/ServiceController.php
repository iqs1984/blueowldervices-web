<?php

namespace App\Http\Controllers\Api;

use App\Model\ServiceCategory;
use App\Model\Service;
use App\Model\ServiceImages;
use App\Model\ServiceOffer;
use App\Model\ServiceQuestions;
use App\Model\UserOffers;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    //
    public function servicecategory(){
        $services = ServiceCategory::get();
        if(count($services) > 0){
            return response()->json(['status'=>'Yes','category'=>$services]);
        }else{
            return response()->json(['status'=>'No','message'=>'Service category not found.']);
        }
    }

    public function serviceoffered(Request $request){
        $services = ServiceOffer::orderBy('id', 'DESC')->orWhere('service_id', $request->service_id)->get();
        if ($request->search) {
            $services->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if (count($services) > 0) {
            return response()->json(['status' => 'Yes', 'offered' => $services]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Service offered not found.']);
        }
    }


    public function getservicequestion(Request $request){
        $service_question = ServiceQuestions::where('service_offer_id',$request->id)->where('question_id',null)->get();
        if (count($service_question) > 0) {
            return response()->json(['status' => 'Yes', 'question' => $service_question]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Service Question not found.']);
        }
    }


    public function getserviceallquestion(Request $request){
        $service_question = ServiceQuestions::where('question_id',$request->id)->get();
        if (count($service_question) > 0) {
            return response()->json(['status' => 'Yes', 'question' => $service_question]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Service Question not found.']);
        }
    }


    public function updateservicedetail(Request $request){
        $user = request()->user('api');
        $validator = Validator::make($request->all(), [
            'service_category' => 'required',
            'service_offered' => 'required',
            'about_service' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        try {

            $update_user =  User::find($user->id);
            if ($request->image) {
                $images = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                $imageName = str_random(30) . '.jpg';
                $new_path = Storage::disk('public')->put($imageName, $images);
                $update_user->imgpath = $imageName;
            }
            $update_user->service_category = $request->service_category;
            $update_user->about_service = $request->about_service;
            $update_user->save();


            if ($request->service_offered) {
                $update_user->useroffer()->detach();
                collect($request->service_offered)->each(function ($value, $key) use ($update_user) {
//                    $service_image = UserOffers::make();
//                    $service_image->user_id = $user->id;
//                    $service_image->offered_id = collect(request()->service_offered)->get($key);
//                    $service_image->save();
                    $update_user->useroffer()->attach($value);
                });
            }


            if ($request->service_image) {
                collect($request->service_image)->each(function ($value, $key) use ($user) {
                    if($value) {
                        $imagess = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $value));
                        $imageName = str_random(30) . '.jpg';
                        $new_path = Storage::disk('public')->put($imageName, $imagess);
                        $service_image = ServiceImages::make();
                        $service_image->user_id = $user->id;
                        $service_image->file_type = $imageName;
                        $service_image->save();
                    }
                });
            }

            return response()->json(['status' => 'Yes', 'message' => 'Service detail updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
    }


}
