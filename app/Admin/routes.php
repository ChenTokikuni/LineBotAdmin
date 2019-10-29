<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

	$router->resource('header_top', HeaderTopController::class);
	$router->resource('header_center', HeaderCenterController::class);
	$router->resource('header_down', HeaderDownController::class);

	$router->resource('picture', PictureController::class);
	$router->resource('notice', NoticeController::class);
	
	$router->resource('main_title', MainTitleController::class);
	$router->resource('main_content', MainContentController::class);
	
	$router->resource('bot_set', BotSetController::class);
	$router->resource('message_send', MessageSendController::class);
	$router->resource('friends_list', FriendsListController::class);
});
