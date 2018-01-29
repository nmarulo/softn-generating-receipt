<?php

namespace App\Controllers;

use Silver\Core\Controller;
use Silver\Http\View;

/**
 * index controller
 */
class IndexController extends Controller {
    
    public function index() {
        return View::make('index');
    }
}
