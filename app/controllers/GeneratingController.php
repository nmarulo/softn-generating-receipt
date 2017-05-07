<?php
/**
 * GeneratingController.php
 */

namespace Softn\controllers;

use Softn\models\Generating;
use Softn\models\GeneratingManager;
use Softn\models\Receipt;
use Softn\models\ReceiptsHasProductsManager;
use Softn\models\ReceiptsManager;
use Softn\util\Arrays;

/**
 * Class GeneratingController
 * @author Nicolás Marulanda P.
 */
class GeneratingController extends ControllerAbstract implements ControllerInterface {
    
    /**
     * GeneratingController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('generating');
    }
    
    public static function init() {
        parent::method(new GeneratingController());
    }
    
    public function generate() {
        $this->getViewForm();
    }
    
    protected function getViewForm() {
        $generatingManager = new GeneratingManager();
        $receipt           = new Receipt();
        $clientId          = Arrays::get($_GET, ReceiptsManager::CLIENT_ID);
        $productsJSON      = Arrays::get($_GET, ReceiptsHasProductsManager::RECEIPT_PRODUCTS);
        $products          = json_decode($productsJSON, TRUE);
        
        $receipt->setClientId($clientId);
        $receipt->setReceiptDate(Arrays::get($_GET, ReceiptsManager::RECEIPT_DATE));
        $receipt->setReceiptNumber(Arrays::get($_GET, ReceiptsManager::RECEIPT_NUMBER));
        $receipt->setReceiptType(Arrays::get($_GET, ReceiptsManager::RECEIPT_TYPE));
        
        $generatingManager->generate($receipt, $products);
    }
    
    public function index() {
        $objectManager = new GeneratingManager();
        ViewController::sendViewData('generating', $objectManager->defaultData());
        ViewController::view('index');
    }
    
}
