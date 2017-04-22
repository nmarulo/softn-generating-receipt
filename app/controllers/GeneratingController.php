<?php
/**
 * GeneratingController.php
 */

namespace Softn\controllers;

use Softn\models\Generating;

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
        
        $this->index();
    }
    
    public function index() {
        ViewController::sendViewData('generating', new Generating());
        ViewController::view('index');
    }
    
    protected function getViewForm() {
        // TODO: Implement getViewForm() method.
    }
    
}
