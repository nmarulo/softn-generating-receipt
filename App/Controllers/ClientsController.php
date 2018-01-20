<?php

namespace App\Controllers;

use App\Facades\Messages;
use App\Models\Clients;
use App\Models\Receipts;
use Silver\Core\Controller;
use Silver\Database\Query;
use Silver\Http\Redirect;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * clients controller
 */
class ClientsController extends Controller {
    
    public function index() {
        return View::make('clients.index')
                   ->with('clients', Clients::query()
                                            ->orderBy('id', 'desc')
                                            ->all());
    }
    
    public function form($id = FALSE) {
        $client      = new Clients();
        $isUpdate    = FALSE;
        $actionValue = 'Nuevo';
        
        if ($id) {
            if (!$client = Clients::find($id)) {
                Messages::addDanger('El cliente no existe.');
                Redirect::to(URL . '/clients');
            }
            
            $isUpdate    = TRUE;
            $actionValue = 'Actualizar';
        }
        
        return $this->viewForm($isUpdate, $actionValue, $client);
    }
    
    private function viewForm($isUpdate, $actionValue, $client) {
        return View::make('clients.form')
                   ->with('isUpdate', $isUpdate)
                   ->with('actionValue', $actionValue)
                   ->with('client', $client);
    }
    
    public function postForm(Request $request) {
        $client                                 = new Clients();
        $id                                     = $request->input('id');
        $client->client_name                    = $request->input('client_name');
        $client->client_address                 = $request->input('client_address');
        $client->client_identification_document = $request->input('client_identification_document');
        $client->client_city                    = $request->input('client_city');
        
        if (empty($id)) {
            $client->client_number_receipts = 0;
            
            if ($client = Clients::create($client->data())) {
                Messages::addSuccess('El cliente ha sido registrado correctamente.');
                Redirect::to(URL . '/clients/form/' . $client->id);
            } else {
                Messages::addDanger('Error al registrar los datos del cliente.');
            }
        } else {
            $client->id = $id;
            
            if ($client->save()) {
                Messages::addSuccess('Cliente actualizado correctamente.');
            } else {
                Messages::addDanger('Error al actualizar los datos del cliente.');
            }
        }
        
        return $this->viewForm(TRUE, 'Actualizar', $client);
    }
    
    public function postDelete(Request $request) {
        $id              = $request->input('id');
        $receipt_numbers = intval(Query::count()
                                       ->from(Receipts::tableName())
                                       ->where('client_id', '=', $id)
                                       ->first()->count);
        
        if ($receipt_numbers == 0) {
            if ($client = Clients::find($id)) {
                $client->delete();
                Messages::addSuccess('Cliente eliminado correctamente.');
            } else {
                Messages::addDanger('El cliente no existe.');
            }
        } else {
            Messages::addDanger('No se puede eliminar un cliente con facturas vinculadas.');
        }
        
        Redirect::to(\URL . '/clients');
    }
    
}
