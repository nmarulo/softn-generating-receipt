<?php
/**
 * ViewController.php
 */

namespace Softn\controllers;

use Softn\util\Arrays;

/**
 * Class ViewController
 * @author Nicolás Marulanda P.
 */
class ViewController {
    
    /** @var string Nombre del directorio de la vista del controlador. */
    private static $DIRECTORY = 'index';
    
    /** @var array Datos a enviar a la vista. */
    private static $VIEW_DATA    = [];
    
    private static $VIEW_CONTENT = '';
    
    /**
     * Método que establece el nombre del directorio de la vista del controlador.
     *
     * @param string $directory
     */
    public static function setDirectory($directory) {
        self::$DIRECTORY = $directory;
    }
    
    /**
     * Método que incluye la vista.
     *
     * @param string $file Nombre de la vista.
     */
    public static function view($fileName) {
        self::setViewContent($fileName);
        self::includeView(VIEWS . 'index.php');
        self::$VIEW_DATA = [];
    }
    
    /**
     * @param string $fileName
     */
    public static function setViewContent($fileName) {
        self::$VIEW_CONTENT = VIEWS . self::$DIRECTORY . DIRECTORY_SEPARATOR . $fileName . '.php';
    }
    
    private static function includeView($path) {
        require $path;
    }
    
    /**
     * Método que establece los datos a enviar a la vista.
     *
     * @param string $key  Indice.
     * @param mixed  $data Datos.
     */
    public static function sendViewData($key, $data) {
        self::$VIEW_DATA[$key] = $data;
    }
    
    public static function header() {
        self::includeView(VIEWS . 'header.php');
    }
    
    public static function footer() {
        self::includeView(VIEWS . 'footer.php');
    }
    
    public static function sidebar() {
        self::includeView(VIEWS . 'sidebar.php');
    }
    
    public static function content() {
        self::includeView(self::$VIEW_CONTENT);
    }
    
    public static function getViewData($key) {
        return Arrays::get(self::$VIEW_DATA, $key);
    }
    
    public static function scriptView($fileName) {
        echo "<script src='app/resources/js/$fileName.js' type='text/javascript'></script>";
    }
    
    public static function styleView($fileName) {
        echo "<link href='app/resources/css/$fileName.css' rel='stylesheet' type='text/css'/>";
    }
}
