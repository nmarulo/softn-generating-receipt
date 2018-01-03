<?php

namespace App\Controllers;

use App\Models\Clients;
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
        $receipt = Receipts::find($request->input('id'));
        $client  = Clients::find($receipt->client_id);
        $receipt->delete();
        $receiptNumber = intval($client->client_number_receipts);
        
        if ($receiptNumber > 0) {
            $client->client_number_receipts = --$receiptNumber;
            $client->save();
        }
        Redirect::to(\URL . '/receipts');
    }
}
