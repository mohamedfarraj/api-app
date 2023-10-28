<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthInterface;

class AuthController extends Controller
{
    protected $authInterface;

    
     /**
     * Create a new constructor for this controller
     */
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;

        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    /**
     * register a newly created User in storage.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        return $this->authInterface->register($request);
    }



    /**
     * Login User And Create Token.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        return $this->authInterface->login($request);
    }

   
     /**
     * logout User And Delete Token.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return $this->authInterface->logout();
    }

}
