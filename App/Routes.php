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
Route::post('/generating', 'Generating@generate', 'unguard');
Route::post('/generating/datapdf', 'Generating@dataPDF', 'unguard');
Route::post('/generating/products', 'Generating@products', 'unguard');
Route::post('/generating/clients', 'Generating@clients', 'unguard');
Route::post('/generating/datamodal', 'Generating@dataModal', 'unguard');
Route::post('/generating/selectedproducts', 'Generating@selectedProducts', 'unguard');

Route::get('/products', 'Products@index', 'unguard');
Route::get('/products/form/{id?}', 'Products@form', 'unguard');
Route::get('/products/delete', 'Products@index', 'unguard');
Route::post('/products/form/{id?}', 'Products@postForm');
Route::post('/products/delete', 'Products@postDelete');

Route::get('/clients', 'Clients@index', 'unguard');
Route::get('/clients/form/{id?}', 'Clients@form', 'unguard');
Route::get('/clients/delete', 'Clients@index');
Route::post('/clients/form/{id?}', 'Clients@postForm');
Route::post('/clients/delete', 'Clients@postDelete');

Route::get('/receipts', 'Receipts@index', 'unguard');
Route::post('/receipts/delete', 'Receipts@postDelete', 'unguard');

Route::get('/settings', 'Settings@index', 'unguard');
