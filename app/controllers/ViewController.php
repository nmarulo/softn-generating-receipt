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
    
    public static function setDirectory($directory) {
        self::$DIRECTORY = $directory;
    }
    
    public static function view($file, $viewData = NULL) {
        if ($viewData !== NULL && is_array($viewData)) {
            extract($viewData, EXTR_PREFIX_INVALID, 'softn');
        }
        
        $contentView = VIEWS . self::$DIRECTORY . DIRECTORY_SEPARATOR . $file . '.php';
        require VIEWS . 'index.php';
    }
}
