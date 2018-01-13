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

Route::get('/', 'Index@index', 'home');

Route::group(['prefix' => 'generating'], function() {
    Route::get('/', 'Generating@index', 'unguard');
    Route::post('/', 'Generating@generate', 'unguard');
    Route::post('/datapdf', 'Generating@dataPDF', 'unguard');
    Route::post('/products', 'Generating@products', 'unguard');
    Route::post('/clients', 'Generating@clients', 'unguard');
    Route::post('/datamodal', 'Generating@dataModal', 'unguard');
    Route::post('/selectedproducts', 'Generating@selectedProducts', 'unguard');
});

Route::group(['prefix' => 'products'], function() {
    Route::get('/', 'Products@index', 'unguard');
    Route::get('/form/{id?}', 'Products@form', 'unguard');
    Route::post('/form/{id?}', 'Products@postForm');
    Route::post('/delete', 'Products@postDelete');
});

Route::group(['prefix' => 'clients'], function() {
    Route::get('/', 'Clients@index', 'unguard');
    Route::get('/form/{id?}', 'Clients@form', 'unguard');
    Route::post('/form/{id?}', 'Clients@postForm');
    Route::post('/delete', 'Clients@postDelete');
});

Route::group(['prefix' => 'receipts'], function() {
    Route::get('/', 'Receipts@index', 'unguard');
    Route::post('/delete', 'Receipts@postDelete', 'unguard');
});

Route::get('/settings', 'Settings@index', 'unguard');

