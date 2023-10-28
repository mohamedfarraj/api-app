<?php

namespace App\Repositories;

use App\Http\Requests\ProductsRequest;
use App\Interfaces\ProductsInterface;
use App\Traits\ResponseAPI;
use App\Models\Products;
use App\Models\Policyprice;
use Illuminate\Support\Facades\Auth;

use DB;

class ProductsRepository implements ProductsInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllProducts()
    {
        try {
            $products = Products::get();
            return $this->success("All Products", $products);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }


    public function getAllProductsByUserType()
    {
        try {
            $products = Products::whereRelation('prices','type',Auth::user()->type)
            ->with(["prices" => function($q){
                $q->where('type', '=', Auth::user()->type);
            }])
            ->withSum(["prices as price" => function($q){
                $q->where('type', '=', Auth::user()->type);
            }],'price')
            ->get();
            return $this->success("All Products", $products);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductsById($id)
    {
        try {
            $product = Products::whereRelation('prices','type',Auth::user()->type)
            ->with(["prices" => function($q){
                $q->where('type', '=', Auth::user()->type);
            }])
            ->withSum(["prices as price" => function($q){
                $q->where('type', '=', Auth::user()->type);
            }],'price')->find($id);
            
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
            $product->slug = $request->slug;
            
            if (!$id) {
                // upload Image file
                $image_path = $request->file('image')->store('image', 'public');
                $product->image = $image_path;
            } else {
                $product->is_active = $request->is_active;
            }
           
            
            // Save the product
            $product->save();
            
            if (!$id) {
                $nid = $product->id;
                foreach (json_decode($request->prices) as $price) {
                    $p =new Policyprice;
                    $p->price = $price->price;
                    $p->type = $price->type;
                    $p->product_id = $nid;
                    $p->save();
                }
            }

            
            
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