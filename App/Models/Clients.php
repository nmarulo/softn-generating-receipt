<?php
/**
 * Clients.php
 */

namespace App\Models;

use Silver\Database\Model;

/**
 * Class Clients
 * @author Nicolás Marulanda P.
 */
class Clients extends Model {
    
    protected static $_table   = 'clients';
    
    protected static $_primary = 'id';
}
