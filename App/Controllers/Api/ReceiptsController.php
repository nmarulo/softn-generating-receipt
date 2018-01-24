<?php

namespace App\Controllers\Api;

use App\Facades\Api;
use App\Models\Receipts;
use Silver\Core\Controller;
use Silver\Http\Request;

/**
 * ReceiptsApi controller
 */
class ReceiptsController extends Controller {
    
    private $resourceName = 'receipts';
    
    public function get() {
        $payload = Receipts::query()
                           ->all(NULL, function($row) {
                               return $row->data();
                           });
        
        return Api::create($payload, 200, $this->resourceName);
    }
    
    public function delete(Request $request) {
        Receipts::find($request->input('id'))
                ->delete();
        
        return json_encode(TRUE);
    }
}
