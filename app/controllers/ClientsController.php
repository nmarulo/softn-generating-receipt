<?php
/**
 * ClientsController.php
 */

namespace Softn\controllers;

use Softn\models\Client;
use Softn\models\ClientsManager;
use Softn\models\ReceiptsManager;
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
            $client = $objectManager->getByID($object->getId());
            $client->setClientIdentificationDocument($object->getClientIdentificationDocument());
            $client->setClientCity($object->getClientCity());
            $client->setClientNumberReceipts($object->getClientNumberReceipts());
            $client->setClientAddress($object->getClientAddress());
            $client->setClientName($object->getClientName());
            $objectManager->update($client);
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
        $message = 'El cliente no existe.';
        $type    = 'danger';
        $id      = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $objectManager = new ClientsManager();
            $message       = 'No se puede borrar el cliente.';
            
            if ($objectManager->delete($id)) {
                $type    = 'success';
                $message = 'Cliente borrado correctamente.';
            }
        }
        
        ViewController::sendViewData('message', $message);
        ViewController::sendViewData('type', $type);
        $this->index();
    }
    
    public function index() {
        ViewController::view('index');
    }
    
    public function dataList() {
        ViewController::sendViewData('viewData', self::getClients());
        ViewController::singleView('datalist');
    }
    
    public static function getClients() {
        $search        = Arrays::get($_GET, 'search');
        $objectManager = new ClientsManager();
        
        if ($search === FALSE) {
            $objects = $objectManager->getAll();
        } else {
            $objects = $objectManager->filter($search);
        }
        
        return $objects;
    }
}
