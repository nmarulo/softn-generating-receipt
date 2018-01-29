<?php

namespace App\Controllers;

use App\Facades\Messages;
use App\Facades\Utils;
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
        $receipts = Receipts::query()
                            ->orderBy('receipt_date', 'desc')
                            ->orderBy('receipt_number', 'desc')
                            ->all(NULL, function($row) {
                                $row->receipt_date = Utils::stringToDate($row->receipt_date, 'Y-m-d', 'd/m/Y');
            
                                return $row;
                            });
        
        return View::make('receipts')
                   ->with('receipts', $receipts);
    }
    
    public function postDelete(Request $request) {
        if ($receipt = Receipts::find($request->input('id'))) {
            if ($client = Clients::find($receipt->client_id)) {
                $this->delete($receipt, $client);
            } else {
                //TODO: borrar o dejar la factura?
                Messages::addDanger('El cliente de la factura no existe.');
            }
        } else {
            Messages::addDanger('El factura no existe.');
        }
        
        Redirect::to(\URL . '/receipts');
    }
    
    private function delete(Receipts $receipt, Clients $client) {
        $receipt->delete();
        Messages::addSuccess('Factura eliminada correctamente.');
        $receiptNumber = intval($client->client_number_receipts);
        
        if ($receiptNumber > 0) {
            $client->client_number_receipts = --$receiptNumber;
            
            if (!$client->save()) {
                Messages::addDanger('Error al actualiza el número de facturas del cliente');
            }
        }
    }
}
