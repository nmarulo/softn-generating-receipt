<?php

namespace App\Controllers\Api;

use App\Facades\Api;
use App\Models\Clients;
use App\Models\Receipts;
use Silver\Core\Controller;
use Silver\Database\Query;
use Silver\Http\Request;

/**
 * Clients controller
 */
class ClientsController extends Controller {
    
    private $resourceName = "clients";
    
    public function get() {
        $payload = Clients::query()
                          ->all(NULL, function($row) {
                              return $row->data();
                          });
        
        return Api::create($payload, 200, $this->resourceName);
    }
    
    public function post(Request $request) {
        $client                                 = new Clients();
        $client->id                             = $request->input('id');
        $client->client_name                    = $request->input('client_name');
        $client->client_address                 = $request->input('client_address');
        $client->client_identification_document = $request->input('client_identification_document');
        $client->client_city                    = $request->input('client_city');
        $client                                 = $client->save();
        
        return Api::create($client->data(), 200, $this->resourceName);
    }
    
    public function put(Request $request) {
        $client                                 = new Clients();
        $client->client_name                    = $request->input('client_name');
        $client->client_address                 = $request->input('client_address');
        $client->client_identification_document = $request->input('client_identification_document');
        $client->client_city                    = $request->input('client_city');
        $client                                 = $client->save();
        
        return Api::create($client->data(), 200, $this->resourceName);
    }
    
    public function delete(Request $request) {
        $id              = $request->input('id');
        $receipt_numbers = intval(Query::count()
                                       ->from(Receipts::tableName())
                                       ->where('client_id', '=', $id)
                                       ->first()->count);
        
        if ($receipt_numbers == 0) {
            $client     = new Clients();
            $client->id = $id;
            $client->delete();
            
            return json_encode(TRUE);
        }
        
        return json_encode(FALSE);
    }
}
