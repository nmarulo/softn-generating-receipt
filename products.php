<?php
/**
 * products.php
 */
require 'common.php';
use Softn\controllers\ProductsController;

ProductsController::init()
                  ->index();
