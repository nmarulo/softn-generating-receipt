<?php

namespace App\Controllers;

use App\Facades\Messages;
use App\Facades\Pagination;
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
    
    public function index(Request $request) {
        return Pagination::viewMake($request, Products::class, 'products', 'products.index', 'products');
    }
    
    public function form($id = FALSE) {
        $product     = new Products();
        $isUpdate    = FALSE;
        $actionValue = 'Nuevo';
        
        if ($id) {
            if (!$product = Products::find($id)) {
                Messages::addDanger('El producto no existe.');
                Redirect::to(URL . '/products');
            }
            
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
            if ($product = Products::create($product->data())) {
                Messages::addSuccess('El producto ha sido registrado correctamente.');
                Redirect::to(URL . '/products/form/' . $product->id);
            } else {
                Messages::addDanger('Error al registrar los datos del producto.');
            }
        } else {
            $product->id = $id;
            
            if ($product->save()) {
                Messages::addSuccess('Producto actualizado correctamente.');
            } else {
                Messages::addDanger('Error al actualizar los datos del producto.');
            }
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
            if ($products = Products::find($id)) {
                $products->delete();
                Messages::addSuccess('Producto eliminado correctamente.');
            } else {
                Messages::addDanger('El producto no existe.');
            }
        } else {
            Messages::addDanger('No se puede eliminar un producto con facturas vinculadas.');
        }
        
        Redirect::to(\URL . '/products');
    }
}
