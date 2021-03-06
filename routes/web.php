<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* --- было после установки и php artisan make:auth --
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index');
*/

Route::resource('/', 'IndexController', [
    'only' => ['index'],
    'names'=> ['index' => 'home']
]);

Route::resource('portfolios', 'PortfolioController', [
    'parameters' => ['portfolios' => 'alias']
]);

Route::resource('articles', 'ArticlesController', [
    'parameters' => ['articles' => 'alias']
]);

Route::get('articles/cat/{cat_alias?}', [
    'uses' => 'ArticlesController@index',
    'as'   => 'articlesCat'
])->where('cat_alias', '[\w-]+');//'[a-zA-Z0-9-]+'

Route::resource('comment','CommentController', [
    'only' => ['store']
]);

Route::match(['get', 'post'], '/contacts', [
    'uses' => 'ContactsController@index',
    'as'   => 'contacts'
]);

// php artisan make:auth (не работает...52 отичается от 54 !!! )
//Route::get('login', 'Auth\LoginController@showLoginForm');
//Route::post('login', 'Auth\LoginController@login');
//Route::get('logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index');

//admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::get('/', [
        'uses' => 'Admin\IndexController@index',
        'as' => 'adminIndex'
    ]);

    // Route::resource('/articles', 'Admin\ArticlesController');
    Route::resource('/articles', 'Admin\ArticlesController', ['names' => [
        'index'   => 'admin.articles.index',
        'create'  => 'admin.articles.create',
        'store'   => 'admin.articles.store',
        'update'  => 'admin.articles.update',
        'destroy' => 'admin.articles.destroy',
        'show' => 'admin.articles.show',
        'edit' => 'admin.articles.edit',
    ]]);

    Route::resource('/permissions', 'Admin\PermissionsController', ['names' => [
        'index'   => 'admin.permissions.index',
        'create'  => 'admin.permissions.create',
        'store'   => 'admin.permissions.store',
        'update'  => 'admin.permissions.update',
        'destroy' => 'admin.permissions.destroy',
        'show' => 'admin.permissions.show',
        'edit' => 'admin.permissions.edit',
    ]]);

    //Route::resource('/users','Admin\UsersController');
    Route::resource('/users', 'Admin\UsersController', ['names' => [
        'index'   => 'admin.users.index',
        'create'  => 'admin.users.create',
        'store'   => 'admin.users.store',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
    ]]);

    Route::resource('/menus', 'Admin\MenusController', ['names' => [
        'index'   => 'admin.menus.index',
        'create'  => 'admin.menus.create',
        'store'   => 'admin.menus.store',
        'update'  => 'admin.menus.update',
        'destroy' => 'admin.menus.destroy',
        'show' => 'admin.menus.show',
        'edit' => 'admin.menus.edit',
    ]]);

    // -----------------------------------------------------------
    // Route::resource('/articles', 'Admin\ArticlesController');
    // делаю сам, этого в курсе небыло...по аналогии с articles
    Route::resource('/portfolios', 'Admin\PortfoliosController', ['names' => [
        'index'   => 'admin.portfolios.index',
        'create'  => 'admin.portfolios.create',
        'store'   => 'admin.portfolios.store',
        'update'  => 'admin.portfolios.update',
        'destroy' => 'admin.portfolios.destroy',
        'show' => 'admin.portfolios.show',
        'edit' => 'admin.portfolios.edit',
    ]]);
    // -----------------------------------------------------------

});

/*Route::get('/admin/articles', [
    'uses' => 'Admin\ArticlesController@index',
    'as'   => 'adminArticles'
])->middleware('auth');*/


/*Route::get('/admin', [
    'uses' => 'Admin\IndexController@index',
    'as'   => 'adminIndex'
])->middleware('auth');*/