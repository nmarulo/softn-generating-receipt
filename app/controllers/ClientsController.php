<?php
/**
 * ClientsController.php
 */

namespace Softn\controllers;

use Softn\models\Client;
use Softn\models\ClientsManager;
use Softn\models\ReceiptsManager;
use Softn\util\Arrays;
use Softn\util\Messages;

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
    
    public function update() {
        $objectManager = new ClientsManager();
        $id            = Arrays::get($_GET, 'update');
        $messages      = FALSE;
        $typeMessage   = Messages::TYPE_DANGER;
        
        if ($id === FALSE) {
            $object = $this->getViewForm();
            $id     = $object->getId();
            
            if ($id == 0) {
                $messages = 'No se puede agregar el cliente.';
                
                if ($objectManager->insert($object)) {
                    $messages    = 'El cliente se agrego correctamente';
                    $typeMessage = Messages::TYPE_SUCCESS;
                }
            } else {
                $messages = 'No se puede actualizar el cliente.';
                
                if ($objectManager->update($id, $object)) {
                    $messages    = 'El cliente se actualizo correctamente';
                    $typeMessage = Messages::TYPE_SUCCESS;
                }
            }
        } else {
            $object = $objectManager->getByID($id);
        }
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessage', $typeMessage);
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
    
    public function insert() {
        ViewController::sendViewData('client', new Client());
        ViewController::view('insert');
    }
    
    public function delete() {
        $messages    = 'El cliente no existe.';
        $typeMessage = Messages::TYPE_DANGER;
        $id          = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $objectManager = new ClientsManager();
            $messages      = 'No se puede borrar el cliente.';
            
            if ($objectManager->delete($id)) {
                $typeMessage = Messages::TYPE_SUCCESS;
                $messages    = 'Cliente borrado correctamente.';
            }
        }
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessage', $typeMessage);
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
