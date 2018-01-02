<?php

namespace App\Controllers;

use App\Models\Products;
use Silver\Core\Controller;
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
        
        return View::make('products.form')
                   ->with('isUpdate', TRUE)
                   ->with('actionValue', 'Actualizar')
                   ->with('product', $product);
    }
}
