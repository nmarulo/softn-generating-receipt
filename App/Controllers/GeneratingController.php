<?php

namespace App\Controllers;

use Silver\Core\Controller;
use Silver\Http\View;

/**
 * generating controller
 */
class GeneratingController extends Controller {
    
    public function index() {
        return View::make('generating');
    }
    
}
