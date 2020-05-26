<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('teste', function () {
//     ini_set('max_execution_time', 0);
//     set_time_limit(0);

    // $folders = scandir(public_path('storage/uploads/products'));

    // foreach ($folders as $folder) {
    //     if ($folder == '.' || $folder == '..') {
    //         continue;
    //     }

    //     $files = scandir(public_path('storage/uploads/products/' . $folder));

    //     foreach ($files as $file) {
    //         if ($file == '.' || $file == '..') {
    //             continue;
    //         }

    //         \App\Models\Image::create([
    //             'image' => $folder . '/' . $file,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         ]);
    //     }
    // }
// });

Route::get('/', 'HomeController@index')->name('home');

Route::post('contato', 'ContactController@send')->name('contact-send');
Route::get('termos-de-uso', 'TermsUseController@index')->name('terms.use');
Route::get('politicas-de-privacidade', 'PrivacyPolicyController@index')->name('privacy.policy');

Route::get('mercado/{mercadoSlug}/busca', 'ProductController@search')->name('products-search');
Route::get('mercado/{marketSlug}/produto/{ProductSlug}', 'ProductController@show')->name('product-show');

Route::group(['middleware' => 'auth', 'prefix' => 'pedidos'], function () {
    Route::get('frete/calcular/{marketId}/{districtId}', 'OrderController@calculateFreight');
    Route::post('salvar', 'OrderController@save')->name('order-save');
    Route::get('cancelar/{orderId}', 'OrderController@cancel')->middleware('auth')->name('order.cancel');
    // Route::get('repetir/{orderId}', 'OrderController@repeat')->middleware('auth')->name('order.repeat');
});

Route::group(['prefix' => 'carrinho'], function () {
    Route::get('finalizar/{marketSlug}', 'CartController@finish')->name('cart-finish')->middleware('auth');
    Route::post('produto/adicionar', 'CartController@addProduct');
    Route::post('limpar/{marketId}', 'CartController@clear')->name('cart-clear');
    Route::post('produto/mensagem', 'CartController@setProductMessage');
});

Route::group(['prefix' => 'usuario'], function () {
    Route::get('cadastro', 'UserController@registerIndex')->name('user.register');
    Route::post('cadastro', 'UserController@register')->name('user.register');

    Route::get('login', 'UserController@loginIndex')->name('user.login');
    Route::post('login', 'UserController@login')->name('user.login');
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'usuario', 'middleware' => 'auth'], function () {
        Route::get('logout', 'Admin\UserController@logout')->name('user.logout');

        Route::get('pedidos', 'Admin\UserController@orders')->name('user.orders');
        Route::get('pedidos/{code}', 'Admin\UserController@orderDetails')->name('user.order.details');

        Route::get('dados', 'Admin\UserController@dataIndex')->name('user.data');
        Route::put('dados', 'Admin\UserController@dataSave')->name('user.data');

        Route::get('acesso', 'Admin\UserController@accessIndex')->name('user.access');
        Route::put('acesso', 'Admin\UserController@accessSave')->name('user.access');

        Route::get('enderecos', 'Admin\UserController@addressesIndex')->name('user.addresses');
        Route::put('enderecos', 'Admin\UserController@addressesSave')->name('user.addresses');

        Route::delete('deletar-conta', 'Admin\UserController@deleteAccount')->name('user.delete.account');
    });

    Route::group(['prefix' => 'nosuper'], function () {
        Route::group(['prefix' => 'mercados'], function () {
            Route::get('cadastro', 'Admin\MarketController@create')->name('market-create');
            Route::post('cadastro', 'Admin\MarketController@store')->name('market-store');

            Route::get('editar/{id}', 'Admin\MarketController@edit')->name('market-edit');
            Route::put('editar/{id}', 'Admin\MarketController@update')->name('market-update');
        });

        Route::group(['prefix' => 'produtos'], function () {
            Route::get('cadastro', 'Admin\ProductController@create')->name('product-create');
            Route::post('cadastro', 'Admin\ProductController@store')->name('product-store');

            Route::get('editar/{id}', 'Admin\ProductController@edit')->name('product.edit');
            Route::put('editar/{id}', 'Admin\ProductController@update')->name('product.update');
        });

        Route::group(['prefix' => 'departamentos'], function () {
            Route::get('cadastro', 'Admin\DepartmentController@create')->name('department-create');
            Route::post('cadastro', 'Admin\DepartmentController@store')->name('department-store');

            Route::get('editar/{id}', 'Admin\DepartmentController@edit')->name('department-edit');
            Route::put('editar/{id}', 'Admin\DepartmentController@update')->name('department-update');
        });

        Route::group(['prefix' => 'categorias'], function () {
            Route::get('cadastro', 'Admin\CategoryController@create')->name('category-create');
            Route::post('cadastro', 'Admin\CategoryController@store')->name('category-store');

            Route::get('editar/{id}', 'Admin\CategoryController@edit')->name('category-edit');
            Route::put('editar/{id}', 'Admin\CategoryController@update')->name('category-update');
        });

        Route::group(['prefix' => 'subcategorias'], function () {
            Route::get('cadastro', 'Admin\SubcategoryController@create')->name('subcategory-create');
            Route::post('cadastro', 'Admin\SubcategoryController@store')->name('subcategory-store');

            Route::get('editar/{id}', 'Admin\SubcategoryController@edit')->name('subcategory-edit');
            Route::put('editar/{id}', 'Admin\SubcategoryController@update')->name('subcategory-update');
        });
    });
});




















// Route::get('automatic/empty', function() {
//     $folders = scandir(public_path('storage/uploads/products'));

//     foreach ($folders as $folder) {
//         if ($folder != '..' && $folder != '.') {
//             $files = scandir(public_path('storage/uploads/products/' . $folder));
//             $files = array_diff($files, ['..', '.']);

//             if (count($files) == 0) {
//                 rmdir(public_path('storage/uploads/products/' . $folder));
//             }
//         }
//     }
// });

// Route::get('automatic/rename', function () {
//     $folders = scandir(public_path('storage/uploads/products'));

//     foreach ($folders as $folder) {
//         if ($folder != '..' && $folder != '.') {
//             // if (preg_match('/\s/', $folder)) {
//                 $files = scandir(public_path('storage/uploads/products/' . $folder));

//                 if (!is_dir(public_path('storage/uploads/products/' . \Str::slug($folder, '-')))) {
//                     mkdir(public_path('storage/uploads/products/' . \Str::slug($folder, '-')), 0777, true);
//                 }

//                 foreach ($files as $file) {
//                     if ($file != '..' && $file != '.') {
//                         rename(public_path('storage/uploads/products/' . $folder . '/' . $file), public_path('storage/uploads/products/' . \Str::slug($folder, '-') . '/' . $file));
//                     }
//                 }

//                 rmdir(public_path('storage/uploads/products/' . $folder));
//             // }
//         }
//     }
// });

// Route::get('automatic/save', function () {
//     $folders = scandir(public_path('storage/uploads/products'));

//     foreach ($folders as $folder) {
//         if ($folder != '..' && $folder != '.') {
//             $files = scandir(public_path('storage/uploads/products/' . $folder));

//             foreach ($files as $file) {
//                 if ($file != '..' && $file != '.') {
//                     \App\Models\Image::create([
//                         'image' => $file
//                     ]);
//                 }
//             }
//         }
//     }
// });
