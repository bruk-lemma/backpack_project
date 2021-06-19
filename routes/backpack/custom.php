<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('post', 'PostCrudController');
    Route::crud('person', 'PersonCrudController');
    Route::crud('women', 'WomenCrudController');
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
    Route::get('charts/yearly-user', 'Charts\YearlyUserChartController@response')->name('charts.yearly-user.index');
    Route::get('charts/usersdata', 'Charts\TotalCommunicationChartController@response')->name('charts.totalcommunication.index');
    Route::get('charts/crmusersdata', 'Charts\CrmusersdataChartController@response')->name('charts.crmusersdata.index');
    Route::crud('datehandler', 'DatehandlerCrudController');
    Route::crud('Communication', 'CommunicationCrudController');
    Route::crud('com', 'ComCrudController');
    Route::get('charts/homie', 'Charts\HomieChartController@response')->name('charts.homie.index');
    Route::get('charts/delivey_walkin', 'Charts\DeliveryWalkinChartController@response')->name('charts.delivery_walkin.index');
    Route::get('charts/delivery-walkin', 'Charts\DeliveryWalkinChartController@response')->name('charts.delivery-walkin.index');
    Route::get('charts/delivery_walkin', 'Charts\DeliveryWalkinChartController@response')->name('charts.delivery_walkin.index');
    Route::get('charts/xshop_brain', 'Charts\XshopBrainChartController@response')->name('charts.xshop_brain.index');
    Route::get('charts/xshopbrain', 'Charts\XshopbrainChartController@response')->name('charts.xshopbrain.index');
    Route::get('charts/deliveredby', 'Charts\DeliveredbyChartController@response')->name('charts.deliveredby.index');
    Route::get('charts/complaint', 'Charts\ComplaintChartController@response')->name('charts.complaint.index');
    Route::get('charts/product_complaint', 'Charts\ProductComplaintChartController@response')->name('charts.product_complaint.index');
    Route::get('charts/service_complaint', 'Charts\ServiceComplaintChartController@response')->name('charts.service_complaint.index');
    Route::get('charts/total-communication', 'Charts\TotalCommunicationChartController@response')->name('charts.total-communication.index');
    Route::get('charts/catagory', 'Charts\CatagoryChartController@response')->name('charts.catagory.index');
    Route::get('charts/catalog', 'Charts\CatalogChartController@response')->name('charts.catalog.index');
    Route::get('charts/evaluation_for_every_product', 'Charts\EvaluationForEveryProductChartController@response')->name('charts.evaluation_for_every_product.index');
    Route::crud('container_information', 'Container_informationCrudController');
    //Route::crud('container_products', 'Container_productsCrudController');
    Route::crud('container_product', 'Container_productCrudController');
    Route::crud('createsells', 'CreatesellsCrudController');
    Route::get('charts/stock_out_forevery_product', 'Charts\StockOutForeveryProductChartController@response')->name('charts.stock_out_forevery_product.index');
    Route::get('charts/machine_stock_out_forevery_machine', 'Charts\MachineStockOutForeveryMachineChartController@response')->name('charts.machine_-stock_out_forevery_machine.index');
    Route::get('charts/other_stock_out_forevery_not_machine', 'Charts\OtherStockOutForeveryNotMachineChartController@response')->name('charts.other_-stock_out_forevery_-not_-machine.index');
}); // this should be the absolute last line of this file
