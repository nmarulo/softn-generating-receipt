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
        $id = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $objectManager = new ReceiptsManager();
            $objectManager->delete($id);
            $receiptHasProductManager = new ReceiptsHasProductsManager();
            $receiptHasProductManager->delete($id);
        }
        
        $this->index();
    }
    
    public function index() {
        $objectManager = new ReceiptsManager();
        ViewController::sendViewData('receipts', $objectManager->getAll());
        ViewController::view('index');
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
            OptionsManager::OPTION_KEY_NAME                    => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_NAME)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_ADDRESS                 => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_ADDRESS)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_WEB_SITE                => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_WEB_SITE)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_IVA                     => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_IVA)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_PHONE_NUMBER            => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_PHONE_NUMBER)
                                                                                 ->getOptionValue(),
            OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT => $optionsManager->selectByKey(OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT)
                                                                                 ->getOptionValue(),
        ];
    }
    
    protected function getViewForm() {
        // TODO: Implement getViewForm() method.
    }
}
