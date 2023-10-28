<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\LoginRequest;

use App\Http\Requests\Auth\RegisterRequest;

interface AuthInterface
{
    /**
     * Register New User
     * 
     * @param   \App\Http\Requests\Auth\RegisterRequest    $request
     * 
     * @method  POST    api/register       For Create New User
     * @access  public
     */
    public function register(RegisterRequest $request);


    /**
     * Login User
     * 
     * @param   \App\Http\Requests\LoginRequest    $request
     * 
     * @method  POST    api/login       For Login
     * @access  public
     */
    public function login(LoginRequest $request);


    /**
     * Logout user
     * 
     * @method  POST  api/logout
     * @access  public
     */
    public function logout();


}