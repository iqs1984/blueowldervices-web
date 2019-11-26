<?php

namespace App\Http\Controllers\Api;

use App\Model\AreaServed;
use App\Model\StripeSubscription;
use App\Model\StripeSubscriptionTransactions;
use App\Model\Subscriptions;
use App\Model\VendorEmployee;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;
use validator;

class SubscriptionController extends Controller
{
    //
    function __construct()
    {
        if (request()->access_token != env('API_TOKEN')) {
            return response()->json(['status' => 'No', 'message' => 'Something is Wrong. Please check your Token.'], 200);
        }
    }

    public function cancelsubscription(Request $request)
    {
        //print_r($request->all());
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $subscription_cancel = Subscription::retrieve($request->subscription_id);
            $subscription_cancel->cancel();

            $canceled_at = date("Y-m-d H:i:s", $subscription_cancel->canceled_at);

            $update_subscription = StripeSubscription::where('subscription_id', '=',  $subscription_cancel->id)->OrderBy('id','DESC')->first();
            $update_subscription->cancel = '1';
            $update_subscription->cancel_at = $canceled_at;
            $update_subscription->save();

            return response()->json(['status' => 'Yes', 'message' => 'Subscription cancel successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'No', 'message' => $e->getMessage()], 200);
        }
    }

    public function resubscribe(Request $request)
    {
        $user = request()->user('api');
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create(array(
                'email' => $user->email,
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

        $user_update = User::find($user->id);
        $user_update->card_last_four = $request->last4;
        $user_update->card_brand = $request->brand;
        $user_update->save();

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

        return response()->json(['status' => 'Yes', 'message' => 'Your monthly plan has been subscribed'], 200);
    }

}
