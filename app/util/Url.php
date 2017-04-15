<?php
/**
 * Url.php
 */

namespace Softn\util;

/**
 * Class Url
 * @author Nicolás Marulanda P.
 */
class Url {
    
    public static function redirect($route) {
        header('Location: http://localhost/softn-generating-receipt/' . $route);
        exit();
    }
}
