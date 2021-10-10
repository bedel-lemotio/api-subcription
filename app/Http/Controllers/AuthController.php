<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userauth = User::with('country')->get();
        //dd($userauth[0]);

        return $this->createNewToken($token,$userauth[0]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'countryCode' => 'required|string',
            'zone' => 'required|string',

        ]);



        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Zone::where('libelle',$request->zone)->get();

        if ($data->isEmpty()){
            return response()->json([
                'success'=> false,
                'message' => 'Zone incorrect choice between AF ou EU',
                'data' => null
            ], 400);
        }

//        $user = User::create(array_merge(
//            $validator->validated(),
//            ['password' => bcrypt($request->password)]
//        ));

        $userIp = $request->ip();
        $locationData = Location::get($userIp);

        $countryuser = Country::where('name',$request->countryCode)->get();
        //dd($countryuser[0]->id);


        if ($locationData != false){
            $country = new Country();
            $country->name = $locationData->countryCode;

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->first_name;
            $user->address_verified = 0;
            $user->identity_verified = 0;
            $countryuser->isEmpty()? $user->country()->create([
                $request->countryCode,
            ])  : $user->countries_id = $countryuser[0]->id;
            $user->zones_id =  $data[0]->id;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        }else{
            $country = new Country();
            $country->name = $request->countryCode;

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->first_name;
            $user->address_verified = 0;
            $user->identity_verified = 0;

            $countryuser->isEmpty()? $user->country()->create([
                $request->countryCode,
            ])  : $user->countries_id = $countryuser[0]->id;
            $user->zones_id =  $data[0]->id;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

        }




        return response()->json([
            'success'=> false,
            'message' => 'User successfully registered',
            'data' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json([
            'success'=> true,
            'message' => 'User successfully signed out',
            'data' => null
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh(),User::with('country')->find(Auth::id()));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(User::with('country')->find(Auth::id()));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token,$user){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'success'=> true,
            'message' => 'User successfully sign in',
            'data' => $user
        ]);
    }

}
