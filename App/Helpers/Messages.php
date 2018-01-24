<?php
/**
 * Messages.php
 */

namespace App\Helpers;

use Silver\Http\Session;

/**
 * Class Messages
 * @author Nicolás Marulanda P.
 */
class Messages {
    
    private static $KEY = 'messages';
    
    public static function addDanger($message) {
        self::add($message, 'danger');
    }
    
    private static function add($message, $type) {
        $messages   = Session::get(self::$KEY, []);
        $messages[] = [
            'message' => $message,
            'type'    => $type,
        ];
        Session::set(self::$KEY, $messages);
    }
    
    public static function addSuccess($message) {
        self::add($message, 'success');
    }
    
    public static function getMessages() {
        $messages = Session::get(self::$KEY, []);
        
        return $messages;
    }
    
    public function isMessages() {
        return Session::exists(self::$KEY) && !empty(Session::get(self::$KEY, []));
    }
    
    public function delete() {
        Session::delete(self::$KEY);
    }
    
}
