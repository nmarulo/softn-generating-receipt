<?php
/**
 * ProductsController.php
 */

namespace Softn\controllers;

use Softn\models\Product;
use Softn\models\ProductsManager;
use Softn\util\Arrays;
use Softn\util\Messages;

/**
 * Class ProductsController
 * @author Nicolás Marulanda P.
 */
class ProductsController extends ControllerCRUDAbstract {
    
    /**
     * ProductsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('products');
    }
    
    public static function init() {
        parent::method(new ProductsController());
    }
    
    public function insert() {
        ViewController::sendViewData('product', new Product());
        ViewController::view('insert');
    }
    
    public function update() {
        $view           = 'index';
        $objectsManager = new ProductsManager();
        $id             = Arrays::get($_GET, 'update');
        $messages       = FALSE;
        $typeMessage    = Messages::TYPE_DANGER;
        
        if ($id === FALSE) {
            $object = $this->getViewForm();
            $id     = $object->getId();
            
            if ($id == 0) {
                $messages = 'No se puede agregar el producto.';
                
                if ($objectsManager->insert($object)) {
                    $messages    = 'El producto se agrego correctamente';
                    $typeMessage = Messages::TYPE_SUCCESS;
                    $view        = 'insert';
                    
                    $object = $objectsManager->getByID($objectsManager->getLastInsertId());
                }
            } else {
                $messages = 'No se puede actualizar el producto.';
                
                if ($objectsManager->update($id, $object)) {
                    $messages    = 'El producto se actualizo correctamente';
                    $typeMessage = Messages::TYPE_SUCCESS;
                    $view        = 'insert';
                }
            }
        } else {
            $object = $objectsManager->getByID($id);
            $view   = 'insert';
            
            if ($object->getId() === 0) {
                $messages = 'El cliente no existe.';
                $view     = 'index';
                $object   = NULL;
            }
        }
        
        if (!empty($object)) {
            ViewController::sendViewData('product', $object);
        }
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessage', $typeMessage);
        ViewController::view($view);
    }
    
    protected function getViewForm() {
        $product = new Product();
        
        $priceUnit = Arrays::get($_GET, ProductsManager::PRODUCT_PRICE_UNIT);
        $priceUnit = filter_var($priceUnit, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $priceUnit = number_format($priceUnit, 2, '.', '');
        
        $product->setId(Arrays::get($_GET, ProductsManager::ID));
        $product->setProductPriceUnit($priceUnit);
        $product->setProductReference(Arrays::get($_GET, ProductsManager::PRODUCT_REFERENCE));
        $product->setProductName(Arrays::get($_GET, ProductsManager::PRODUCT_NAME));
        
        
        return $product;
    }
    
    public function delete() {
        $messages    = 'El producto no existe.';
        $typeMessage = Messages::TYPE_DANGER;
        $id          = Arrays::get($_GET, 'delete');
        
        if ($id !== FALSE) {
            $objectManager = new ProductsManager();
            $messages      = 'No se puede borrar el producto.';
            
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
        ViewController::sendViewData('viewData', self::getProducts());
        ViewController::singleView('datalist');
    }
    
    public static function getProducts() {
        $search        = Arrays::get($_GET, 'search');
        $objectManager = new ProductsManager();
        
        if ($search === FALSE) {
            $objects = $objectManager->getAll();
        } else {
            $objects = $objectManager->filter($search);
        }
        
        return $objects;
    }
}
