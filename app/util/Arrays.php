<?php
/**
 * Arrays.php
 */

namespace Softn\util;

/**
 * Class Arrays
 * @author Nicolás Marulanda P.
 */
class Arrays {
    
    /**
     * Método que obtiene el valor de un array según su indice.
     *
     * @param $array
     * @param $key
     *
     * @return bool|mixed Retorna FALSE si no es un array o el indice no existe.
     */
    public static function get($array, $key) {
        if (self::keyExists($array, $key)) {
            return $array[$key];
        }
        
        return FALSE;
    }
    
    public static function keyExists($array, $key) {
        return is_array($array) && array_key_exists($key, $array);
    }
    
    public static function valueExists($array, $value) {
        return is_array($array) && array_search($value, $array) !== FALSE;
    }
}
