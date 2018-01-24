<?php

namespace App\Controllers;

use Silver\Core\Controller;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * Messages controller
 */
class MessagesController extends Controller {
    
    public function post(Request $request) {
        if ($request->ajax()) {
            return View::make('components.messages');
        }
        
        //TODO: mensaje de error.
        return "";
    }
}
