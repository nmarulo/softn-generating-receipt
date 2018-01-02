<?php

namespace App\Controllers;

use App\Models\Settings;
use Silver\Core\Controller;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * settings controller
 */
class SettingsController extends Controller {
    
    public function index() {
        return $this->sendData(View::make('settings'));
    }
    
    private function sendData($make) {
        return $make->with('valueName', Settings::where('option_key', '=', 'option_name')
                                                ->first())
                    ->with('valueIdentificationDocument', Settings::where('option_key', '=', 'option_identification_document')
                                                                  ->first())
                    ->with('valueAddress', Settings::where('option_key', '=', 'option_address')
                                                   ->first())
                    ->with('valuePhoneNumber', Settings::where('option_key', '=', 'option_phone_number')
                                                       ->first())
                    ->with('valueWebSite', Settings::where('option_key', '=', 'option_web_site')
                                                   ->first());
    }
    
    public function postForm(Request $request) {
    
    }
}
