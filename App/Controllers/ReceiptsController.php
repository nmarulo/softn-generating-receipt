<?php

namespace App\Controllers;

use App\Models\Receipts;
use Silver\Core\Controller;
use Silver\Http\Redirect;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * receipts controller
 */
class ReceiptsController extends Controller {
    
    public function index() {
        return View::make('receipts')
                   ->with('receipts', Receipts::query()
                                              ->orderBy('receipt_number', 'desc')
                                              ->all());
    }
    
    public function postDelete(Request $request) {
        $receipt = new Receipts();
        $receipt->id = $request->input('id');
        $receipt->delete();
        Redirect::to('/receipts');
    }
}
