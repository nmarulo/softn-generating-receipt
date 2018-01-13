<?php

namespace App\Controllers;

use App\Models\Settings;
use Silver\Core\Controller;
use Silver\Http\Redirect;
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
        return $make->with('valueName', $this->getValue('option_name'))
                    ->with('valueIdentificationDocument', $this->getValue('option_identification_document'))
                    ->with('valueAddress', $this->getValue('option_address'))
                    ->with('valuePhoneNumber', $this->getValue('option_phone_number'))
                    ->with('valueWebSite', $this->getValue('option_web_site'))
                    ->with('valueIVA', $this->getValue('option_iva'));
    }
    
    private function getValue($value) {
        return Settings::where('option_key', '=', $value)
                       ->first();
    }
    
    public function postForm(Request $request) {
        $settings = new Settings();
        
        $this->saveSetting($request, $settings, 'option_name');
        $this->saveSetting($request, $settings, 'option_identification_document');
        $this->saveSetting($request, $settings, 'option_address');
        $this->saveSetting($request, $settings, 'option_phone_number');
        $this->saveSetting($request, $settings, 'option_web_site');
        $this->saveSetting($request, $settings, 'option_iva');
        
        Redirect::to(\URL . '/settings');
    }
    
    private function saveSetting(Request $request, Settings $settings, $input) {
        $settings               = Settings::where('option_key', '=', $input)
                                          ->first();
        $settings->option_value = $request->input($input);
        $settings->save();
    }
}
