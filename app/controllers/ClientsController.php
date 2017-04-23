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
        $objectManager = new ClientsManager();
        $object        = $this->getViewForm();
        $id            = Arrays::get($_GET, 'update');
        
        if ($object->getId() == 0) {
            if ($id !== FALSE) {
                $object = $objectManager->getByID($id);
            } else {
                $objectManager->insert($object);
            }
        } else {
            $objectManager->update($object);
        }
        
        ViewController::sendViewData('client', $object);
        ViewController::view('insert');
    }
    
    /**
     * @return Client
     */
    protected function getViewForm() {
        $client = new Client();
        $client->setId(Arrays::get($_GET, ClientsManager::ID));
        $client->setClientName(Arrays::get($_GET, ClientsManager::CLIENT_NAME));
        $client->setClientAddress(Arrays::get($_GET, ClientsManager::CLIENT_ADDRESS));
        $client->setClientCity(Arrays::get($_GET, ClientsManager::CLIENT_CITY));
        $client->setClientIdentificationDocument(Arrays::get($_GET, ClientsManager::CLIENT_IDENTIFICATION_DOCUMENT));
        
        return $client;
    }
    
    public function delete() {
        $id = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $objectManager = new ClientsManager();
            $objectManager->delete($id);
        }
        
        $this->index();
    }
    
    public function index() {
        $objectManager = new ClientsManager();
        
        ViewController::sendViewData('clients', $objectManager->getAll());
        ViewController::view('index');
    }
    
    public function getClientsJSON() {
        $objectManager = new ClientsManager();
        $objects       = $objectManager->getAll();
        $objectsJSON   = json_encode($objects);
    
        echo $objectsJSON;
    }
}
