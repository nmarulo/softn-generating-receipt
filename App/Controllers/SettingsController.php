<?php

namespace App\Controllers;

use App\Facades\Messages;
use App\Models\Settings;
use Silver\Core\Controller;
use Silver\Http\Redirect;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * settings controller
 */
class SettingsController extends Controller {
    
    private $error;
    
    public function index() {
        return $this->sendData(View::make('settings'));
    }
    
    private function sendData($make) {
        return $make->with('valueName', $this->getValue('option_name'))
                    ->with('valueIdentificationDocument', $this->getValue('option_identification_document'))
                    ->with('valueAddress', $this->getValue('option_address'))
                    ->with('valuePhoneNumber', $this->getValue('option_phone_number'))
                    ->with('valueWebSite', $this->getValue('option_web_site'))
                    ->with('valueIVA', $this->getValue('option_iva'))
                    ->with('valueDateFormat', $this->getValue('setting_date_format'));
    }
    
    private function getValue($value) {
        return Settings::where('option_key', '=', $value)
                       ->first();
    }
    
    public function postForm(Request $request) {
        $this->error = FALSE;
        $settings    = new Settings();
        
        $this->saveSetting($request, $settings, 'option_name');
        $this->saveSetting($request, $settings, 'option_identification_document');
        $this->saveSetting($request, $settings, 'option_address');
        $this->saveSetting($request, $settings, 'option_phone_number');
        $this->saveSetting($request, $settings, 'option_web_site');
        $this->saveSetting($request, $settings, 'option_iva');
        $this->saveSetting($request, $settings, 'setting_date_format');
        
        if ($this->error) {
            Messages::addDanger('Error al actualizar.');
        } else {
            Messages::addSuccess('Actualizado correctamente.');
        }
        
        Redirect::to(\URL . '/settings');
    }
    
    private function saveSetting(Request $request, Settings $settings, $input) {
        if ($this->error || ($result = $request->input($input, FALSE)) === FALSE) {
            return;
        }
        
        $settings               = Settings::where('option_key', '=', $input)
                                          ->first();
        $settings->option_value = $result;
        $this->error            = !$settings->save();
    }
}
