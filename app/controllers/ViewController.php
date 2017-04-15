<?php
/**
 * ViewController.php
 */

namespace Softn\controllers;

/**
 * Class ViewController
 * @author Nicolás Marulanda P.
 */
class ViewController {
    
    private static $DIRECTORY = 'index';
    
    private static $VIEW_DATA = ['viewData' => ''];
    
    public static function setDirectory($directory) {
        self::$DIRECTORY = $directory;
    }
    
    public static function view($file) {
        extract(self::$VIEW_DATA, EXTR_PREFIX_INVALID, 'softn');
        self::$VIEW_DATA = ['viewData' => ''];
        $contentView     = VIEWS . self::$DIRECTORY . DIRECTORY_SEPARATOR . $file . '.php';
        require VIEWS . 'index.php';
    }
    
    public static function sendViewData($key, $data) {
        self::$VIEW_DATA['viewData'][$key] = $data;
    }
}
