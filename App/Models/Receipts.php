<?php
/**
 * Receipts.php
 */

namespace App\Models;

use Silver\Database\Model;

/**
 * Class Receipts
 * @author Nicolás Marulanda P.
 */
class Receipts extends Model {
    
    protected static $_table   = 'receipts';
    
    protected static $_primary = 'id';
}
