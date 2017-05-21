<?php
/**
 * GeneratingController.php
 */

namespace Softn\controllers;

use Softn\models\Generating;
use Softn\models\GeneratingManager;
use Softn\models\ProductsManager;
use Softn\models\Receipt;
use Softn\models\ReceiptHasProduct;
use Softn\models\ReceiptsHasProductsManager;
use Softn\models\ReceiptsManager;
use Softn\util\Arrays;
use Softn\util\Messages;

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
        $notError          = FALSE;
        $messages          = 'No se puede generar la factura.';
        $typeMessage       = Messages::TYPE_DANGER;
        $generating        = $this->getViewForm();
        $generatingManager = new GeneratingManager();
        
        if ($generatingManager->generate($generating)) {
            $messages    = 'La factura se genero correctamente.';
            $typeMessage = Messages::TYPE_SUCCESS;
            $notError    = TRUE;
        }
        
        echo json_encode([
            'messages'    => $messages,
            'typeMessage' => $typeMessage,
            'notError'    => $notError,
        ]);
    }
    
    protected function getViewForm() {
        $generating             = new Generating();
        $receipt                = new Receipt();
        $clientId               = Arrays::get($_GET, ReceiptsManager::CLIENT_ID);
        $productsIdAndUnitsJSON = Arrays::get($_GET, ReceiptsHasProductsManager::RECEIPT_PRODUCTS);
        $productsIdAndUnits     = json_decode($productsIdAndUnitsJSON, TRUE);
        $receiptHasProducts     = $this->getReceiptHasProducts($productsIdAndUnits);
        
        $receipt->setClientId($clientId);
        $receipt->setReceiptDate(Arrays::get($_GET, ReceiptsManager::RECEIPT_DATE));
        $receipt->setReceiptNumber(Arrays::get($_GET, ReceiptsManager::RECEIPT_NUMBER));
        $receipt->setReceiptType(Arrays::get($_GET, ReceiptsManager::RECEIPT_TYPE));
        $generating->setReceipt($receipt);
        $generating->setReceiptsHasProducts($receiptHasProducts);
        
        return $generating;
    }
    
    private function getReceiptHasProducts($productsIdAndUnits) {
        $receiptHasProducts = [];
        
        if (!is_array($productsIdAndUnits)) {
            $productsIdAndUnits = [];
        }
        
        foreach ($productsIdAndUnits as $productAndUnits) {
            $productId         = Arrays::get($productAndUnits, ProductsManager::ID);
            $productUnits      = Arrays::get($productAndUnits, ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT);
            $receiptHasProduct = new ReceiptHasProduct();
            
            $receiptHasProduct->setProductId($productId);
            $receiptHasProduct->setReceiptProductUnit($productUnits);
            
            $receiptHasProducts[] = $receiptHasProduct;
        }
        
        return $receiptHasProducts;
    }
    
    public function messages() {
        $messages    = Arrays::get($_GET, 'messages');
        $typeMessage = Arrays::get($_GET, 'typeMessage');
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessage', $typeMessage);
        parent::messages();
    }
    
    public function index() {
        $objectManager = new GeneratingManager();
        ViewController::sendViewData('generating', $objectManager->defaultData());
        ViewController::view('index');
    }
    
    public function selectedProducts() {
        $productsIdAndUnits = Arrays::get($_GET, 'productsIdAndUnits');
        $dataView           = [];
        $productsManager    = new ProductsManager();
        
        if ($productsIdAndUnits !== FALSE) {
            foreach ($productsIdAndUnits as $value) {
                $product    = $productsManager->getByID($value[ProductsManager::ID]);
                $units      = $value[ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT];
                $dataView[] = [
                    'product'                                        => $product,
                    ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT => $units,
                ];
            }
        }
        
        ViewController::sendViewData('dataView', $dataView);
        ViewController::singleView('selectedproducts');
    }
    
    public function dataList() {
        $dataView      = [];
        $search        = [];
        $methodGetData = Arrays::get($_GET, 'methodGetData');
        $methodGetId   = Arrays::get($_GET, 'methodGetId');
        $methodGetName = Arrays::get($_GET, 'methodGetName');
        
        if ($methodGetId !== FALSE && $methodGetName !== FALSE && $methodGetData !== FALSE) {
            if (method_exists($this, $methodGetData)) {
                $search = call_user_func([
                    $this,
                    $methodGetData,
                ]);
            }
            
            foreach ($search as $value) {
                if (method_exists($value, $methodGetId) && method_exists($value, $methodGetName)) {
                    $dataView[] = [
                        'dataId'   => call_user_func([
                            $value,
                            $methodGetId,
                        ]),
                        'showText' => call_user_func([
                            $value,
                            $methodGetName,
                        ]),
                    ];
                }
            }
        }
        
        ViewController::sendViewData('dataView', $dataView);
        ViewController::singleView('datalist');
    }
    
    private function getClients() {
        return ClientsController::getClients();
    }
    
    private function getProducts() {
        return ProductsController::getProducts();
    }
}
