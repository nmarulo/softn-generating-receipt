<?php
/**
 * ReceiptsController.php
 */

namespace Softn\controllers;

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
    
    protected function getViewForm() {
        // TODO: Implement getViewForm() method.
    }
}
