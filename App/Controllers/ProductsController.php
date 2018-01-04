<?php

namespace App\Controllers;

use App\Models\Products;
use App\Models\ReceiptsProducts;
use Silver\Core\Controller;
use Silver\Database\Query;
use Silver\Http\Redirect;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * products controller
 */
class ProductsController extends Controller {
    
    public function index() {
        return View::make('products.index')
                   ->with('products', Products::query()
                                              ->orderBy('id', 'desc')
                                              ->all());
    }
    
    public function form($id = FALSE) {
        $product     = new Products();
        $isUpdate    = FALSE;
        $actionValue = 'Nuevo';
        
        if ($id) {
            $product     = Products::find($id);
            $isUpdate    = TRUE;
            $actionValue = 'Actualizar';
        }
        
        return $this->viewForm($isUpdate, $actionValue, $product);
    }
    
    private function viewForm($isUpdate, $actionValue, $product) {
        return View::make('products.form')
                   ->with('isUpdate', $isUpdate)
                   ->with('actionValue', $actionValue)
                   ->with('product', $product);
    }
    
    public function postForm(Request $request) {
        $product                     = new Products();
        $id                          = $request->input('id');
        $product->product_name       = $request->input('product_name');
        $product->product_price_unit = $request->input('product_price_unit');
        $product->product_reference  = $request->input('product_reference');
        
        if (empty($id)) {
            $product = Products::create($product->data());
        } else {
            $product->id = $id;
            $product->save();
        }
        
        return $this->viewForm(TRUE, 'Actualizar', $product);
    }
    
    public function postDelete(Request $request) {
        $id               = $request->input('id');
        $receipt_products = intval(Query::count()
                                        ->from(ReceiptsProducts::tableName())
                                        ->where('product_id', '=', $id)
                                        ->first()->count);
        
        if ($receipt_products == 0) {
            $products     = new Products();
            $products->id = $id;
            $products->delete();
        }
        
        Redirect::to(\URL . '/products');
    }
}
