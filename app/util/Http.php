<?php
/**
 * Httpp.php
 */

namespace Softn\util;

/**
 * Class Http
 * @author Nicolás Marulanda P.
 */
class Http {
    
    public static function redirect($route) {
        header('Location: http://localhost/softn-generating-receipt/' . $route);
        exit();
    }
}
