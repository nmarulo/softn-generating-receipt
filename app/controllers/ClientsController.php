<?php
/**
 * ClientsController.php
 */

namespace Softn\controllers;

use Softn\models\Client;
use Softn\models\ClientsManager;
use Softn\util\Arrays;

/**
 * Class ClientsController
 * @author Nicolás Marulanda P.
 */
class ClientsController extends ControllerAbstract implements ControllerCRUDInterface {
    
    /**
     * ClientsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('clients');
    }
    
    public static function init() {
        parent::method(new ClientsController());
    }
    
    public function insert() {
        ViewController::sendViewData('client', new Client());
        ViewController::view('insert');
    }
    
    public function update() {
        $clientsManager = new ClientsManager();
        $client         = $this->getViewForm();
        $id             = Arrays::get($_GET, 'update');
        
        if ($client->getId() == 0) {
            if ($id !== FALSE) {
                $client = $clientsManager->getByID($id);
            } else {
                $clientsManager->insert($client);
            }
        } else {
            $clientsManager->update($client);
        }
        
        ViewController::sendViewData('client', $client);
        ViewController::view('insert');
    }
    
    /**
     * @return Client
     */
    private function getViewForm() {
        $client = new Client();
        $client->setId(Arrays::get($_GET, 'id'));
        $client->setClientName(Arrays::get($_GET, 'clientName'));
        $client->setClientAddress(Arrays::get($_GET, 'clientAddress'));
        $client->setClientCity(Arrays::get($_GET, 'clientCity'));
        $client->setClientIdentificationDocument(Arrays::get($_GET, 'clientIdentificationDocument'));
        
        return $client;
    }
    
    public function delete() {
        $id = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $clientManager = new ClientsManager();
            $clientManager->delete($id);
        }
        
        $this->index();
    }
    
    public function index() {
        $clientsManager = new ClientsManager();
        
        ViewController::sendViewData('clients', $clientsManager->getAll());
        ViewController::view('index');
    }
}
