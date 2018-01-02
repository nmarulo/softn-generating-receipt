<?php
/**
 * Products.php
 */

namespace App\Models;

use Silver\Database\Model;

/**
 * Class Products
 * @author Nicolás Marulanda P.
 */
class Products extends Model {
    
    protected static $_table   = 'products';
    
    protected static $_primary = 'id';
    
}
