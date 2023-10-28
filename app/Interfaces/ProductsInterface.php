<?php

namespace App\Interfaces;

use App\Http\Requests\ProductsRequest;

interface ProductsInterface
{
    /**
     * Get all products
     * 
     * @method  GET api/products
     * @access  public
     */
    public function getAllProducts();

    /**
     * Get all products for user by type
     * 
     * @method  GET api/products/byUserType
     * @access  public
     */
    public function getAllProductsByUserType();

    /**
     * Get Products By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/products/{id}
     * @access  public
     */
    public function getProductsById($id);

    /**
     * Create | Update product
     * 
     * @param   \App\Http\Requests\ProductsRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/products       For Create
     * @method  PUT     api/products/{id}  For Update     
     * @access  public
     */
    public function requestProducts(ProductsRequest $request, $id = null);

    /**
     * Delete product
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/products/{id}
     * @access  public
     */
    public function deleteProducts($id);
}