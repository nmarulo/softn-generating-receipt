<?php

namespace App\Controllers;

use App\Models\Receipts;
use Silver\Core\Controller;
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
}
