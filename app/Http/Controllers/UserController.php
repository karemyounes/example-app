<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{

    // register function

    public function register(Request $request)
    {
        if($request->hasFile('picture'))
        {
            $validation = $request->validate(
            [
                'name' => 'required|string',
                'address' => 'required|string',
                'password' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'phone' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg' ,

            ]);}



        $image = Time() . '.' . $request->picture->extension() ;
        $request->picture->move(public_path('userpicture', $image));

        $user = User::create([
            'name' => $request->name ,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,
            'picture' => $image ,
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =
        [
            'user' => $user,
            'token' => $token,
        ];

        return response($response);

    }

    // login function

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email',$request->email)->first();

        if($user == null || !Hash::check($request->password , $user->password))
        {
            $message = ['message' => 'we canot find any email like that'];
            return response($message);
        }
        else
        {
            $token = $user -> createToken('myapptoken') -> plainTextToken ;
            $response = 
            [
                'user' => $user,
                'token' => $token
            ];
            return response($response); 
        }}

    public function logout()
    {
        auth()-> user() -> tokens() -> delete();
        return ['message' => 'logged out'];
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }



}
