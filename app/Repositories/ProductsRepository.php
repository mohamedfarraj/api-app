<?php

namespace App\Repositories;

use App\Http\Requests\ProductsRequest;
use App\Interfaces\ProductsInterface;
use App\Traits\ResponseAPI;
use App\Models\Products;
use DB;

class ProductsRepository implements ProductsInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllProducts()
    {
        try {
            $products = Products::all();
            return $this->success("All Products", $products);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductsById($id)
    {
        try {
            $product = Products::find($id);
            
            // Check the product
            if(!$product) return $this->error("No product with ID $id", 404);

            return $this->success("Products Detail", $product);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestProducts(ProductsRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If product exists when we find it
            // Then update the product
            // Else create the new one.
            $product = $id ? Products::find($id) : new Products;

            // Check the product 
            if($id && !$product) return $this->error("No product with ID $id", 404);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->type = $request->type;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->is_active = $request->is_active;

            if (!$id) {
                // upload Image file
                $product_path = $request->file('image')->store('image', 'public');
                $product->image = $product_path;
            }
            // Save the product
            $product->save();

            DB::commit();
            return $this->success(
                $id ? "Products updated"
                    : "Products created",
                $product, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteProducts($id)
    {
        DB::beginTransaction();
        try {
            $product = Products::find($id);

            // Check the product
            if(!$product) return $this->error("No product with ID $id", 404);

            // Delete the product
            $product->delete();

            DB::commit();
            return $this->success("Products deleted", $product);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}