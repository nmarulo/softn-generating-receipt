<?php
/**
 * Settings.php
 */

namespace App\Models;

use Silver\Database\Model;

/**
 * Class Settings
 * @author Nicolás Marulanda P.
 */
class Settings extends Model {
    
    protected static $_table   = 'options';
    
    protected static $_primary = 'id';
}
