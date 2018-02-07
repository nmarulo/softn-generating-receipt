<?php

namespace App\Controllers;

use App\Facades\DataTableHTML;
use App\Facades\Messages;
use App\Facades\Pagination;
use App\Facades\Utils;
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
    
    public function index(Request $request) {
        return Pagination::viewMake($request, Clients::class, 'clients', 'clients.index', 'clients', DataTableHTML::orderBy($request, Clients::class));
    }
    
    public function form(Request $request, $id = FALSE) {
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
        
        return $this->viewForm($request, $isUpdate, $actionValue, $client, $id);
    }
    
    private function viewForm(Request $request, $isUpdate, $actionValue, $client, $clientId) {
        if (empty($clientId)) {
            return View::make('clients.form')
                       ->with('isUpdate', $isUpdate)
                       ->with('actionValue', $actionValue)
                       ->with('client', $client)
                       ->with('receipts', []);
        }
        
        $currentModel = function() use ($clientId) {
            return Query::count()
                        ->from(Receipts::tableName())
                        ->where('client_id', '=', $clientId)
                        ->single();
        };
        $dataModel    = function($limit, $offset) use ($clientId) {
            return $this->getReceipts($clientId, $limit, $offset);
        };
        
        return Pagination::viewMake($request, $currentModel, 'receipts', 'clients.form', $clientId, $dataModel)
                         ->with('isUpdate', $isUpdate)
                         ->with('actionValue', $actionValue)
                         ->with('client', $client);
    }
    
    private function getReceipts($clientId, $limit, $offset) {
        return Receipts::query()
                       ->where('client_id', '=', $clientId)
                       ->orderBy('receipt_date', 'desc')
                       ->orderBy('receipt_number', 'desc')
                       ->limit($limit)
                       ->offset($offset)
                       ->all(NULL, function($row) {
                           $row->receipt_date = Utils::stringToDate($row->receipt_date, 'Y-m-d', Utils::getDateFormat());
            
                           return $row;
                       });
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
        
        return $this->viewForm($request, TRUE, 'Actualizar', $client, $id);
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
