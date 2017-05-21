<?php
/**
 * ReceiptsController.php
 */

namespace Softn\controllers;

use Softn\models\Client;
use Softn\models\ClientsManager;
use Softn\models\OptionsManager;
use Softn\models\Product;
use Softn\models\ProductsManager;
use Softn\models\Receipt;
use Softn\models\ReceiptsHasProductsManager;
use Softn\models\ReceiptsManager;
use Softn\util\Arrays;
use Softn\util\Messages;

/**
 * Class ReceiptsController
 * @author Nicolás Marulanda P.
 */
class ReceiptsController extends ControllerAbstract implements ControllerCRUDInterface {
    
    /**
     * ReceiptsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('receipts');
    }
    
    public static function init() {
        parent::method(new ReceiptsController());
    }
    
    public function insert() {
        // TODO: Implement insert() method.
    }
    
    public function update() {
        // TODO: Implement update() method.
    }
    
    public function delete() {
        $messages    = 'La factura no existe.';
        $typeMessage = Messages::TYPE_DANGER;
        $id          = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $messages      = 'No se puede borrar la factura.';
            $objectManager = new ReceiptsManager();
            
            /*
             * No se borran manualmente los datos de la tabla "ReceiptsHasProduct"
             * ya que estos datos se borraran en cascada luego de borrar la factura.
             */
            if ($objectManager->delete($id)) {
                $typeMessage = Messages::TYPE_SUCCESS;
                $messages    = 'Factura borrada correctamente.';
            }
            
        }
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessage', $typeMessage);
        $this->index();
    }
    
    public function index() {
        ViewController::view('index');
    }
    
    public function lastInsert() {
        $receiptsManager = new ReceiptsManager();
        
        echo json_encode($receiptsManager->getLast());
    }
    
    public function dataPDF() {
        $id       = Arrays::get($_GET, 'id');
        $dataJSON = [
            'client'   => NULL,
            'products' => [],
            'receipt'  => NULL,
            'options'  => NULL,
        ];
        
        if ($id !== FALSE) {
            $clientsManager      = new ClientsManager();
            $receiptsManager     = new ReceiptsManager();
            $receiptsHasProducts = new ReceiptsHasProductsManager();
            $productsManager     = new ProductsManager();
            $receipt             = $receiptsManager->getByID($id);
            $client              = $clientsManager->getByID($receipt->getClientId());
            $receiptHasProducts  = $receiptsHasProducts->getByID($id);
            $dataJSON['client']  = $client;
            $dataJSON['receipt'] = $receipt;
            $dataJSON['options'] = $this->getOptions();
            
            foreach ($receiptHasProducts as $receiptHasProduct) {
                $dataJSON['products'][] = [
                    'product'              => $productsManager->getByID($receiptHasProduct->getProductId()),
                    'receipt_product_unit' => $receiptHasProduct->getReceiptProductUnit(),
                ];
            }
        }
        
        echo json_encode($dataJSON);
    }
    
    private function getOptions() {
        $optionsManager = new OptionsManager();
        
        return [
            OptionsManager::OPTION_KEY_NAME                    => $optionsManager->getByKey(OptionsManager::OPTION_KEY_NAME)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_ADDRESS                 => $optionsManager->getByKey(OptionsManager::OPTION_KEY_ADDRESS)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_WEB_SITE                => $optionsManager->getByKey(OptionsManager::OPTION_KEY_WEB_SITE)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_IVA                     => $optionsManager->getByKey(OptionsManager::OPTION_KEY_IVA)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_PHONE_NUMBER            => $optionsManager->getByKey(OptionsManager::OPTION_KEY_PHONE_NUMBER)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT => $optionsManager->getByKey(OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT)
                                                                                 ->getOptionValue(),
        ];
    }
    
    public function dataList() {
        ViewController::sendViewData('viewData', self::getReceipts());
        ViewController::singleView('datalist');
    }
    
    private function getReceipts() {
        $search        = Arrays::get($_GET, 'search');
        $objectManager = new ReceiptsManager();
        
        if ($search === FALSE) {
            $object = $objectManager->getAll();
        } else {
            $object = $objectManager->filter($search);
        }
        
        return $object;
    }
    
    protected function getViewForm() {
        // TODO: Implement getViewForm() method.
    }
}
