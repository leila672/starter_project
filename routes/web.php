<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('heloo', function () {
    return view('heloo');
});

Route::get('master', function () {
    return view('layout/master');
});

Route::get('landing', function () {
    return view('landing');
});

Route::get('/home', function () {
    return 'welcome';
});

Route::resource('news','Auth\controller@getIndex');



Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home') -> middleware ('verified') ;

Route::get('/', function () {
    return 'home' ;
});




Route::group(
    [
        'prefix'=> LaravelLocalization::setLocale() ,
        'middleware' => [ 'localizationRedirect', 'localeViewPath']
    ],function() {
    Route::group(['prefix'=>"offers"],function() {
        Route::get('create', 'CurdController@create');
        Route::post('store', 'CurdController@store')->name('offers.store');

        Route::get('edit/{offer_id}', 'CurdController@editOffer');
        Route::post('update/{offer_id}', 'CurdController@updateOffer')->name('offers.update');
        Route::get('delete/{offer_id}', 'CurdController@deleteOffer')->name('offers.delete');
        Route::get('all', 'CurdController@getAllOffers') -> name('offers.all');

    });
});




Route::get('/dashboard', function () {

    return 'Not adualt';
}) -> name('not.adult');
#################### Begin Authentication && Guards ##############

Route::group(['middleware' => 'checkAge','namespace' => 'Auth'], function () {
    Route::get('adults', 'CustomAuthController@adult')-> name('adult');
});
//middleware('auth')
Route::get('site', 'Auth\CustomAuthController@site')->middleware('auth:web')-> name('site');
Route::get('admin', 'Auth\CustomAuthController@admin')->middleware('auth:admin') -> name('admin');

Route::get('admin/login', 'Auth\CustomAuthController@adminLogin')-> name('admin.login');
Route::post('admin/login', 'Auth\CustomAuthController@checkAdminLogin')-> name('save.admin.login');

##################### End Authentication && Guards #############


################### Begin relations  routes ######################

Route::get('has-one','Relation\RelationsController@hasOneRelation');
Route::get('has-one-reserve','Relation\RelationsController@hasOneRelationReverse');

Route::get('get-user-has-phone','Relation\RelationsController@getUserHasPhone');

Route::get('get-user-has-phone-with-condition','Relation\RelationsController@getUserWhereHasPhoneWithCondition');

Route::get('get-user-not-has-phone','Relation\RelationsController@getUserNotHasPhone');


################## Begin one To many Relationship #####################

Route::get('hospital-has-many','Relation\RelationsController@getHospitalDoctors');

Route::get('hospitals','Relation\RelationsController@hospitals') -> name('hospital.all');

Route::get('doctors/{hospital_id}','Relation\RelationsController@doctors')-> name('hospital.doctors');

Route::get('hospitals/{hospital_id}','Relation\RelationsController@deleteHospital') -> name('hospital.delete');

Route::get('hospitals_has_doctors','Relation\RelationsController@hospitalsHasDoctor');

Route::get('hospitals_has_doctors_male','Relation\RelationsController@hospitalsHasOnlyMaleDoctors');

Route::get('hospitals_not_has_doctors','Relation\RelationsController@hospitals_not_has_doctors');


################## End one To many Relationship ##############

################## Begin  Many To many Relationship #####################

Route::get('doctors-services','Relation\RelationsController@getDoctorServices');

Route::get('service-doctors','Relation\RelationsController@getServiceDoctors');

Route::get('doctors/services/{doctor_id}','Relation\RelationsController@getDoctorServicesById')-> name('doctors.services');
Route::post('saveServices-to-doctor','Relation\RelationsController@saveServicesToDoctors')-> name('save.doctors.services');


################## End Many To many Relationship #####################


