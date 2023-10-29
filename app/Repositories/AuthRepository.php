<?php

namespace App\Repositories;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;
    
    public function register(RegisterRequest $request)
    {
        try {
            // create the new one.
            $user = new User;
            
            $user->username = $request->username;
            $user->name = $request->name;
            $user->type = $request->type;

            // upload Avatar file
            $avatar_path = $request->file('avatar')->store('avatar', 'public');
            $user->avatar = $avatar_path;

            // Remove a whitespace and make to lowercase
            $user->email = preg_replace('/\s+/', '', strtolower($request->email));
            
            // Password Hashed.
            $user->password = \Hash::make($request->password);

            // Save the user
            $user->save();

            
            return $this->success("User created", $user,  201);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }


    public function login(LoginRequest $request)
    {

        try {
            // If user exists when we find it
            $credentials = $request->only('email', 'password');
            
            // If user exists And password is correct
            // return token
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $data = [
                    'user' => $user,
                    'authorization' => [
                        'token' => $user->createToken('ApiToken')->plainTextToken,
                        'type' => 'bearer',
                    ]
                ];
                return $this->success("User LogIn", $data,  200);
            }else{
                
                return $this->error("User Not Found or Password Not Correct", 401);
            }

        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return $this->success("Successfully logged out", [],  200);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    
}