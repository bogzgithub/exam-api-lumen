<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;
//use App\Models\User;
use App\Users;
use Validator;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    //
     /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('username', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
    }

    public function postRegister(Request $request)
    {

        /*DB::table('users')->insert(
            ["id" => "1b7161ea8542462dbf21db4ca9e66288",
                'name' => 'sam',
                'email' => 'sam@mail.com',
                'password' => Hash::make("sam1"),
            ]
        );*/
       //print_r($request->input());
        $validator = Validator::make($request->all(),
        [
            "username" => "required|min:5|max:50|unique:users",
            "password"=>"required|min:5|max:50"

        ]);

        if ($validator->fails()){
            return response()->json(["errors" => $validator->errors()]);
        }

        $users = new Users;
        $users->username = $request->input("username");
        $users->password = Hash::make("password");
        $users->remember_token = "";
        $users->save();

        return response()->json(['data' => "Successfully Saved!"]);
    }

    public function logout( Request $request ) {
        return response()->json(['data' => "Destroyed Token"]);
    }

    public function testAuthenticate()
    {
        return response()->json(['data' => "Authenticate"]);
    }

    public function getUsers(){
        $users = Users::all();
        return response()->json(['data' => $users]);
    }
}
