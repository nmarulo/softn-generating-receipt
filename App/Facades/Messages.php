<?php
/**
 * Messages.php
 */

namespace App\Facades;

use Silver\Support\Facade;

/**
 * Class Messages
 * @author Nicolás Marulanda P.
 */
class Messages extends Facade {
    
    protected static function getClass() {
        return 'App\Helpers\Messages';
    }
}
