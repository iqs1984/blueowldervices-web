<?php

namespace App\Http\Controllers\Api;

use App\Model\AreaServed;
use App\Model\ServiceOffer;
use App\Model\VendorEmployee;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    //
    function __construct()
    {
        if (request()->access_token != env('API_TOKEN')) {
            return response()->json(['status' => 'No', 'message' => 'Something is Wrong. Please check your Token.'], 200);
        }
    }

    public function addarea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        try {
            $user = request()->user('api');
            $area_served = AreaServed::make();
            $area_served->user_id = $user->id;
            $area_served->lat = $request->lat;
            $area_served->long = $request->long;
            $area_served->save();

            return response()->json(['status' => 'Yes', 'message' => 'Area added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
    }


    public function allarea(Request $request)
    {
        $user = request()->user('api');
        $area = AreaServed::orderBy('id', 'ASC')->orWhere('user_id', $user->id)->get();
        if (count($area) > 0) {
            return response()->json(['status' => 'Yes', 'area' => $area]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Area not found.']);
        }
    }

    public function editarea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $user = request()->user('api');
        $area = AreaServed::find($request->id);
        $area->user_id = $user->id;
        $area->lat = $request->lat;
        $area->long = $request->long;
        $area->save();

        return response()->json(['status' => 'Yes', 'message' => 'Area updated successfully.']);
    }


    public function area_module(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }
        $lat = $request->lat;
        $lng = $request->long;
        $areas =DB::select("SELECT * FROM (SELECT *, ( ( ( acos( sin(( $lat * pi() / 180)) * sin(( `lat` * pi() / 180)) + cos(( $lat * pi() /180 )) * cos(( `lat` * pi() / 180)) * cos((( $lng - `long`) * pi()/180))) ) * 180/pi()) * 60 * 1.1515 * 1.609344)as distance FROM `area_serveds` ) area_serveds WHERE distance <= 20 LIMIT 15");

        if($areas == null){
            $areas = 'Service not available at this location.';
            return response()->json(['status' => 'No', 'message' => $areas]);
        }else {
            return response()->json(['status' => 'Yes', 'area' => $areas, 'message' => 'Service available']);
        }
    }


    public function deletearea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $delete_area = AreaServed::find($request->id);
        $delete_area->delete();
        return response()->json(['status' => 'Yes', 'message' => 'Area deleted successfully.']);
    }


}
