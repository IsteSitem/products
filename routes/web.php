<?php

$namespace = '\IsteSitem\Products\Http\Controllers';

Route::group([
    'prefix' => 'products', // Must match its `slug` record in the DB > `data_types`
    'middleware' => ['web'],
    'as' => 'istesitem.products.',
    'namespace' => $namespace,
], function () {
    Route::get('/', ['uses' => 'ProductController@getProducts', 'as' => 'list']);
    Route::get('{slug}', ['uses' => 'ProductController@getProduct', 'as' => 'single']);
});
