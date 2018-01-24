<?php

/**
 * SilverEngine  - PHP MVC framework
 * @package   SilverEngine
 * @author    SilverEngine Team
 * @copyright 2015-2017
 * @license   MIT
 * @link      https://github.com/SilverEngine/Framework
 */

namespace App\Routes;

use Silver\Core\Route;

Route::group(['prefix' => 'api'], function() {
    Route::get('/clients', 'Api/Clients@get', 'unguard');
    Route::post('/clients', 'Api/Clients@post', 'unguard');
    Route::put('/clients', 'Api/Clients@put', 'unguard');
    Route::delete('/clients', 'Api/Clients@delete', 'unguard');
    Route::get('/products', 'Api/Products@get', 'unguard');
    Route::post('/products', 'Api/Products@post', 'unguard');
    Route::put('/products', 'Api/Products@put', 'unguard');
    Route::delete('/products', 'Api/Products@delete', 'unguard');
    Route::get('/receipts', 'Api/Receipts@get', 'unguard');
    Route::delete('/receipts', 'Api/Receipts@delete', 'unguard');
});
