<?php
/**
 * ControllerAbstract.php
 */

namespace Softn\controllers;

use Softn\util\Arrays;

/**
 * Class ControllerAbstract
 * @author Nicolás Marulanda P.
 */
abstract class ControllerAbstract {
    
    protected static function method($instance) {
        $method    = 'index';
        $methodGet = Arrays::get($_GET, 'method');
        
        if ($methodGet !== FALSE && !empty($methodGet) && method_exists($instance, $methodGet)) {
            $method = $methodGet;
        }
        
        ViewController::sendViewData('method', $method);
        
        call_user_func_array([
            $instance,
            $method,
        ], ['']);
    }
}
