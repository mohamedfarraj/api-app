<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductsRequest;
use App\Interfaces\ProductsInterface;

class ProductsController extends Controller
{
    protected $productsInteface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(ProductsInterface $productsInterface)
    {
        $this->productsInterface = $productsInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productsInterface->getAllProducts();
    }

    /**
     * Display a listing By User Type.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProductsByUserType()
    {
        return $this->productsInterface->getAllProductsByUserType();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        return $this->productsInterface->requestProducts($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productsInterface->getProductsById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        return $this->productsInterface->requestProducts($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->productsInterface->deleteProducts($id);
    }
}
