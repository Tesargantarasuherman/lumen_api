
<?php
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Generate Aplication Key

$router->get('/key',function (){
    return Str::random(32);
});

$router->get('/foo',function (){
    return 'Hello, GET method';
});

// name alias
$router->get('/profile',['as'=>'route.profile',function(){
    return route('route.profile');
}]);
// end nama Alias
// mengelompokkan route
$router->group(['prefix' => 'user'],function()use ($router){
    $router->get('home',['middleware' => 'age'],function(){
        return 'Home User' ;
    });

    $router->get('profile',function(){
        return 'Profile User' ;
    });
});

// end mengelompokan route
// middelware 
$router->get('/admin/home',['middleware' => 'age',function(){
    return 'Home Admin' ;
}]);
$router->get('/fail',function(){
    return 'fail' ;
});

// end middleware

// AUTH
$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');
$router->get('/user/{id}','UserController@show');
$router->post('/logout','AuthController@logout');

// TURNAMEN
$router->post('/turnamen/tambah-turnamen','TurnamenController@tambahTurnamen');
$router->get('/turnamen','TurnamenController@index');
// Tim
$router->post('/tim/tambah-tim','TimController@tambahTim');
$router->post('/tim/tambah-anggotatim','AnggotaTimController@tambahAnggotaTim');
$router->get('/tim/{id}/anggotatim','AnggotaTimController@anggotaTim');
// KLASEMEN
$router->post('/klasemen/tambah-klub','KlasemenController@tambahKlub');
$router->get('/klasemen/{id}','KlasemenController@index');
// SKOR
$router->post('/pertandingan/update-skor','SkorController@update');
$router->get('/pertandingan/top-skor/{id}','SkorController@topSkor');
$router->get('/image/{imageName}','ImageController@logoTim');

// PERTANDINGAN
$router->get('/pertandingan/{id}','PertandinganController@index');
$router->get('/hasil-pertandingan/{id}','PertandinganController@hasilPertandingan');
$router->post('/pertandingan/tambah-pertandingan','PertandinganController@tambahPertandingan');
$router->post('/pertandingan/update-pertandingan/{id}','PertandinganController@updatePertandingan');
