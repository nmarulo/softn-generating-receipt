<?php

namespace App\Controllers\Api;

use App\Facades\Api;
use App\Models\Products;
use App\Models\ReceiptsProducts;
use Silver\Core\Controller;
use Silver\Database\Query;
use Silver\Http\Request;

/**
 * ProductsApi controller
 */
class ProductsController extends Controller {
    
    private $resourceName = 'products';
    
    public function get() {
        $payload = Products::query()
                           ->all(NULL, function($row) {
                               return $row->data();
                           });
        
        return Api::create($payload, 200, $this->resourceName);
    }
    
    public function post(Request $request) {
        $product                     = new Products();
        $product->id                 = $request->input('id');
        $product->product_name       = $request->input('product_name');
        $product->product_price_unit = $request->input('product_price_unit');
        $product->product_reference  = $request->input('product_reference');
        $product                     = $product->save();
        
        return Api::create($product->data(), 200, $this->resourceName);
    }
    
    public function put(Request $request) {
        $product                     = new Products();
        $product->product_name       = $request->input('product_name');
        $product->product_price_unit = $request->input('product_price_unit');
        $product->product_reference  = $request->input('product_reference');
        $product                     = $product->save();
        
        return Api::create($product->data(), 200, $this->resourceName);
    }
    
    public function delete(Request $request) {
        $id               = $request->input('id');
        $receipt_products = intval(Query::count()
                                        ->from(ReceiptsProducts::tableName())
                                        ->where('product_id', '=', $id)
                                        ->first()->count);
        
        if ($receipt_products == 0) {
            $products     = new Products();
            $products->id = $id;
            $products->delete();
            
            return json_encode(TRUE);
        }
        
        return json_encode(FALSE);
    }
}
