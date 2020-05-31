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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'usuario', 'middleware' => 'auth'], function () {
        Route::get('logout', 'UserController@logout')->name('user.logout');

        Route::get('pedidos', 'UserController@orders')->name('user.orders');
        Route::get('pedidos/{code}', 'UserController@orderDetails')->name('user.order.details');

        Route::get('dados', 'UserController@dataIndex')->name('user.data');
        Route::put('dados', 'UserController@dataSave')->name('user.data');

        Route::get('acesso', 'UserController@accessIndex')->name('user.access');
        Route::put('acesso', 'UserController@accessSave')->name('user.access');

        Route::get('enderecos', 'UserController@addressesIndex')->name('user.addresses');
        Route::put('enderecos', 'UserController@addressesSave')->name('user.addresses');

        Route::delete('deletar-conta', 'UserController@deleteAccount')->name('user.delete.account');
    });

    Route::group(['prefix' => 'nosuper', 'namespace' => 'Nosuper'], function () {
        Route::get('login', 'NoSuperController@loginIndex')->name('nosuper.login');
        Route::post('login', 'NoSuperController@login')->name('nosuper.login');

        Route::group(['middleware' => 'auth:nosuper'], function () {
            Route::get('index', 'NoSuperController@index')->name('nosuper.index');

            Route::get('logout', 'NoSuperController@logout')->name('nosuper.logout');

            Route::group(['prefix' => 'mercados'], function () {
                Route::get('/', 'MarketController@index')->name('nosuper.market.index');

                Route::get('cadastro', 'MarketController@create')->name('nosuper.market.create');
                Route::post('cadastro', 'MarketController@store')->name('nosuper.market.store');

                Route::get('editar/{id}', 'MarketController@edit')->name('nosuper.market.edit');
                Route::put('editar/{id}', 'MarketController@update')->name('nosuper.market.update');

                Route::get('deletar/{id}', 'MarketController@delete')->name('nosuper.market.delete');
            });

            Route::group(['prefix' => 'produtos'], function () {
                Route::get('/', 'ProductController@index')->name('nosuper.product.index');

                Route::get('cadastro', 'ProductController@create')->name('nosuper.product.create');
                Route::post('cadastro', 'ProductController@store')->name('nosuper.product.store');

                Route::get('editar/{id}', 'ProductController@edit')->name('nosuper.product.edit');
                Route::put('editar/{id}', 'ProductController@update')->name('nosuper.product.update');

                Route::get('deletar/{id}', 'ProductController@delete')->name('nosuper.product.delete');
            });

            Route::group(['prefix' => 'departamentos'], function () {
                Route::get('/', 'DepartmentController@index')->name('nosuper.department.index');

                Route::get('cadastro', 'DepartmentController@create')->name('nosuper.department.create');
                Route::post('cadastro', 'DepartmentController@store')->name('nosuper.department.store');

                Route::get('editar/{id}', 'DepartmentController@edit')->name('nosuper.department.edit');
                Route::put('editar/{id}', 'DepartmentController@update')->name('nosuper.department.update');

                Route::get('deletar/{id}', 'DepartmentController@delete')->name('nosuper.department.delete');
            });

            Route::group(['prefix' => 'categorias'], function () {
                Route::get('/', 'CategoryController@index')->name('nosuper.category.index');

                Route::get('cadastro', 'CategoryController@create')->name('nosuper.category.create');
                Route::post('cadastro', 'CategoryController@store')->name('nosuper.category.store');

                Route::get('editar/{id}', 'CategoryController@edit')->name('nosuper.category.edit');
                Route::put('editar/{id}', 'CategoryController@update')->name('nosuper.category.update');

                Route::get('deletar/{id}', 'CategoryController@delete')->name('nosuper.category.delete');
            });

            Route::group(['prefix' => 'subcategorias'], function () {
                Route::get('/', 'SubcategoryController@index')->name('nosuper.subcategory.index');

                Route::get('cadastro', 'SubcategoryController@create')->name('nosuper.subcategory.create');
                Route::post('cadastro', 'SubcategoryController@store')->name('nosuper.subcategory.store');

                Route::get('editar/{id}', 'SubcategoryController@edit')->name('nosuper.subcategory.edit');
                Route::put('editar/{id}', 'SubcategoryController@update')->name('nosuper.subcategory.update');

                Route::get('deletar/{id}', 'SubcategoryController@delete')->name('nosuper.subcategory.delete');
            });
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
