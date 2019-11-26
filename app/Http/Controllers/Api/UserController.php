<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\App;
use App\Model\AreaServed;
use App\Model\ServiceCategory;
use App\Model\ServiceImages;
use App\Model\ServiceOffer;
use App\Model\StripeSubscription;
use App\Model\StripeSubscriptionTransactions;
use App\Model\Subscriptions;
use App\Model\SubscriptionItem;
use App\Model\UserOffers;
use App\Model\VendorEmployee;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Subscription;
use Stripe\Invoice;
use Twilio\Rest\Client;

class UserController extends Controller
{
    function __construct()
    {
        if (request()->access_token != env('API_TOKEN')) {
            return response()->json(['status' => 'No', 'message' => 'Something is Wrong. Please check your Token.']);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $email = request()->email;
        $password = request()->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $role = $user->role;
            $token = $user->createToken('LoginToken')->accessToken;
            return response()->json(['status' => 'Yes', 'message' => 'You have Successfully login.', 'token' => $token, 'role' => $role], 200);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Email or password is wrong. Please try different Credentials.'], 200);
        }
    }

    public function logout()
    {
        $user = request()->user('api');
        if ($user) {
            $user->token()->revoke();
            return response()->json(['status' => 'Yes', 'message' => 'You have logged out successfully.']);
        } else {
            return response()->json(['status' => 'No', 'message' => 'You have logged out already.']);
        }
    }


    // profile image
    public function profileImage(Request $request)
    {
        $user = request()->user('api');
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }
        try {
            $images = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
            $imageName = str_random(30) . '.jpg';
            $new_path = Storage::disk('public')->put($imageName, $images);
            $user = User::find($user->id);
            $user->imgpath = $imageName;
            $user->save();
            return response()->json(['status' => 'Yes', 'message' => 'Profle Image upload successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }

    }


    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $user = request()->user('api');

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return response()->json(['status' => 'Yes', 'message' => 'Password change successfully.'], 200);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Invalid old password'], 200);
        }
    }


    public function getdetail()
    {
        $user = request()->user('api');
        $category = ServiceCategory::where('id', $user->service_category)->get();
        $offered = ServiceOffer::where('service_id', $user->service_offered)->get();
        $images = ServiceImages::where('user_id', $user->id)->get();
        $useroffer = UserOffers::with('offers')->where('user_id', $user->id)->get();
        $sub_detail = StripeSubscription::where('user_id', $user->id)->OrderBy('id', 'Desc')->first();
        if ($user) {
            return response()->json(['status' => 'Yes', 'message' => 'Record found.', 'data' => $user, 'service_category' => $category, 'service_offered' => $useroffer, 'service_images' => $images, 'subscription_detail' => $sub_detail]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'No record is found.']);
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $already_email = User::whereEmail(request()->email)->get();
        if (count($already_email) > 0) {
            return response()->json(['status' => 'No', 'message' => 'Email is already Exists. Please try another Email.'], 200);
        }

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create(array(
                'email' => $request->email,
                'source' => $request->tokenId
            ));

            $subscribe = Subscription::create([
                "customer" => $customer->id,
                "items" => [
                    [
                        "plan" => "plan_FyD0sKwti4O8my",
                    ],
                ]
            ]);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        $user = User::make();
        $user->email = $request->email;
        $user->companyname = $request->company_name;
        $user->phone = $request->phone;
        $user->role = 'vendor';
        $user->licence_number = $request->licence_number;
        $user->website_url = $request->website_url;
        $user->yelp_url = $request->yelp_url;
        $user->service_category = $request->service_category;
        $user->about_service = $request->about_service;
        $user->card_brand = $request->brand;
        $user->card_last_four = $request->last4;
        $user->password = bcrypt($request->password);
        if ($request->image) {
            $images = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
            $imageName = str_random(30) . '.jpg';
            $new_path = Storage::disk('public')->put($imageName, $images);
            $user->imgpath = $imageName;
        }
        $user->save();

        $area_served = AreaServed::make();
        $area_served->user_id = $user->id;
        $area_served->lat = $request->lat;
        $area_served->long = $request->long;
        $area_served->save();

        $subscribe_date = date("Y-m-d H:i:s", $subscribe->created);
        $subscribe_start_date = date("Y-m-d H:i:s", $subscribe->current_period_start);
        $subscribe_end_date = date("Y-m-d H:i:s", $subscribe->current_period_end);

        $subscriptions = StripeSubscription::make();
        $subscriptions->user_id = $user->id;
        $subscriptions->subscription_id = $subscribe->id;
        $subscriptions->customer_id = $subscribe->customer;
        $subscriptions->subscription_at = $subscribe_date;
        $subscriptions->save();

        $val = [];
        foreach ($subscribe->items->data as $datas) {
            $val[] = array(
                'id' => $datas->id,
                'created' => $datas->created,
                'interval' => $datas->plan->interval,
                'amount' => $datas->plan->amount,

            );
        }
        $start_date = date("Y-m-d H:i:s", $val[0]['created']);
        $amount = $val[0]['amount'] / 100;

        $subscriptions_item = StripeSubscriptionTransactions::make();
        $subscriptions_item->sub_id = $subscriptions->id;
        $subscriptions_item->transaction_id = $val[0]['id'];
        $subscriptions_item->subscription_type = $val[0]['interval'];
        $subscriptions_item->amount = '$' . $amount;
        $subscriptions_item->start_date = $subscribe_start_date;
        $subscriptions_item->end_date = $subscribe_end_date;
        $subscriptions_item->save();


        if ($request->service_image) {
            collect($request->service_image)->each(function ($value, $key) use ($user) {
                $imagess = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $value));
                $imageName = str_random(30) . '.jpg';
                $new_path = Storage::disk('public')->put($imageName, $imagess);
                $service_image = ServiceImages::make();
                $service_image->user_id = $user->id;
                $service_image->file_type = $imageName;
                $service_image->save();
            });
        }


        if ($request->service_offered) {
            $user->useroffer()->detach();
            collect($request->service_offered)->each(function ($value, $key) use ($user) {
                $user->useroffer()->attach($value);
            });
        }
		
		$sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
        $client = new Client( $sid, $token );
		 
		$client->messages->create( 
                   '+919808980809',
                   [
                       'from' => env( 'TWILIO_FROM' ),
                       'body' => 'hello',
                   ]
               );

        $token = $user->createToken('Login')->accessToken;
        return response()->json(['status' => 'Yes', 'message' => 'Your monthly plan has been subscribed', 'token' => $token], 200);
    }

    public function gettransaction(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            //$subscribe = BalanceTransaction::all(['limit' => 3]);
            $subscribe = Charge::all(['limit' => 3, 'customer' => 'cus_FyD5QEcSeClecs']);

            return response()->json(['status' => 'Yes', 'message' => $subscribe], 200);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function gettoken(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $subscribe = Token::create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 10,
                    'exp_year' => 2020,
                    'cvc' => '314'
                ]
            ]);
            return response()->json(['status' => 'Yes', 'message' => $subscribe], 200);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function getinvoice(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $subscribe = Invoice::all(['limit' => 3]);
            return response()->json(['status' => 'Yes', 'message' => $subscribe], 200);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function AddEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        try {
            $user = request()->user('api');
            $vendor_employee = VendorEmployee::make();
            $vendor_employee->user_id = $user->id;
            $vendor_employee->employee_name = $request->employee_name;
            $vendor_employee->designation = $request->designation;
            if ($request->image) {
                $images = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                $imageName = str_random(30) . '.jpg';
                $new_path = Storage::disk('public')->put($imageName, $images);
                $vendor_employee->imgpath = $imageName;
            }
            $vendor_employee->save();
            return response()->json(['status' => 'Yes', 'message' => 'Employee added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
    }


    public function editemployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        try {
            $user = request()->user('api');
            $update_employee = VendorEmployee::find($request->id);
            $update_employee->user_id = $user->id;
            $update_employee->employee_name = $request->employee_name;
            $update_employee->designation = $request->designation;
            if ($request->image) {
                $images = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                $imageName = str_random(30) . '.jpg';
                $new_path = Storage::disk('public')->put($imageName, $images);
                $update_employee->imgpath = $imageName;
            }
            $update_employee->save();
            return response()->json(['status' => 'Yes', 'message' => 'Employee updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
    }


    public function employeelist(Request $request)
    {
        $user = request()->user('api');
        $employeelist = VendorEmployee::where('user_id', $user->id)->get();
        if (count($employeelist) > 0) {
            return response()->json(['status' => 'Yes', 'employees' => $employeelist]);
        } else {
            return response()->json(['status' => 'No', 'message' => 'Employee list not found.']);
        }
    }

    public function deleteemployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        $delete_employee = VendorEmployee::find($request->id);
        $delete_employee->delete();
        return response()->json(['status' => 'Yes', 'message' => 'Employee deleted successfully.']);
    }

    public function getlocationdetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'No', 'message' => @implode(',', $validator->errors()->all())], 200);
        }

        try {
            $served = AreaServed::with(['user_detail.services.offers','images'])->find($request->id);
            return response()->json(['status' => 'Yes', 'message' => 'Location detail fetch successfully.', 'data' => $served]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }

    }


}
