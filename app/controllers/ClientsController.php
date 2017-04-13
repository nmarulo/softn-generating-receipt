<?php
/**
 * ClientsController.php
 */

namespace Softn\controllers;

/**
 * Class ClientsController
 * @author Nicolás Marulanda P.
 */
class ClientsController implements ControllerCRUDInterface {
    
    /**
     * ClientsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('clients');
    }
    
    public static function init() {
        return new ClientsController();
    }
    
    public function insert($object) {
        // TODO: Implement insert() method.
    }
    
    public function update($object) {
        // TODO: Implement update() method.
    }
    
    public function delete($id) {
        // TODO: Implement delete() method.
    }
    
    public function index() {
        $viewData = [
            'clients' => [
                'cl 01',
                'cl 02',
                'cl 03',
                'cl 04',
                'cl 05',
            ]
        ];
        
        ViewController::view('index', $viewData);
    }
}
