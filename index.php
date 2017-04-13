<?php
/**
 * Inicio de la aplicación.
 */
require 'common.php';
use Softn\controllers\IndexController;

IndexController::init()
               ->index();
