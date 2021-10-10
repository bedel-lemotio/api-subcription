<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;


class SubscriptionController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function init(Request $request){

        $userauth = User::with('zone')->get();
        $subscription = Subscription::with('subscription_type')->where('subscription_zone',$userauth[0]->zone->libelle)->get();

        return response()->json([
            'success'=> true,
            'message' => "",
            'data' => $subscription
        ]);
    }


    public function subscribe(Request $request){

        $userauth = Auth::user();
        $subscription = Subscription::find($request->id);
        if(is_null($subscription)){
            return response()->json([
                'success'=> false,
                'message' => 'Wrong subscription id',
                'data' => null
            ], 400);
        }

        $userauth->subscriptions_id = $request->id;
        $userauth->save();

        return response()->json([
            'success'=> true,
            'message' => "subscription success",
            'data' => $userauth
        ]);
    }

}
