<?php

/**
 * SilverEngine  - PHP MVC framework
 * @package   SilverEngine
 * @author    SilverEngine Team
 * @copyright 2015-2017
 * @license   MIT
 * @link      https://github.com/SilverEngine/Framework
 */

namespace App;

use Silver\Core\Route;

Route::get('/', 'Index@index', 'home');
Route::get('/generating', 'Generating@index', 'unguard');
Route::get('/products', 'Products@index', 'unguard');
Route::get('/products/form/{id?}', 'Products@form', 'unguard');
Route::post('/products/form/{id?}', 'Products@postForm');
Route::get('/clients', 'Clients@index', 'unguard');
Route::get('/clients/form/{id?}', 'Clients@form', 'unguard');
Route::post('/clients/form/{id?}', 'Clients@postForm');
Route::get('/receipts', 'Receipts@index', 'unguard');
Route::get('/settings', 'Settings@index', 'unguard');
