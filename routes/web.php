<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

if (env( 'APP_ENV' ) !== 'production') {
    Route::get( '/design', 'PageController@design' )->name( 'design' );
}

Route::get( '/concept', 'PageController@concept' )->name( 'concept' );

Route::get( '/devenir-partenaire', 'PageController@devenirPartenaire' )->name( 'devenir-partenaire' );

Route::get( '/equipe', 'PageController@equipe' )->name( 'equipe' );


Route::get( '/', 'PageController@home' )->name( 'home' );

Route::group( ['prefix' => 'ajax'], function () {
    Route::get( 'job', 'JobController@search' );
    Route::get( 'school', 'SchoolController@search' );
    Route::get( 'association', 'AssociationController@search' );
    Route::put( 'me', 'UserController@updateMe' )->middleware( ['role:candidate'] )->name( 'candidate_update_me' );

} );

/*
 * GENERAL AUTHENTICATION
 */

// Authentication Routes...
Route::get( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );


/*
 * CANDIDATE
 */

Route::post( '/candidate/login', 'Auth\LoginController@login' )->name( 'candidate_login' );
Route::get( '/candidate/linkedin', 'Auth\RegisterController@linkedin' )->name( 'candidate_login_linkedin' );
Route::get( '/candidate/redirect_to_linkedin', 'Auth\RegisterController@redirectToLinkedin' )->name( 'candidate_redirect_to_linkedin' );
Route::post( '/candidate/register', 'Auth\RegisterController@register' )->name( 'candidate_register' );


Route::get( '/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password_reset' );
Route::post( '/password/reset/', 'Auth\ResetPasswordController@reset' );
Route::post( '/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'send_email_forgotten_password' );


/*
 * ADMINISTRATION
 */

// Admin auth routes
Route::get( '/admin/login', '\Backpack\Base\app\Http\Controllers\Auth\LoginController@showLoginForm' );
Route::post( '/admin/login', '\Backpack\Base\app\Http\Controllers\Auth\LoginController@login' );
Route::get( '/admin/logout', '\Backpack\Base\app\Http\Controllers\Auth\LoginController@logout' );

// TODO: remove in production, no open registration for admins !
Route::get( '/admin/register', 'Admin\Auth\RegisterController@showRegistrationForm' );
Route::post( '/admin/register', 'Admin\Auth\RegisterController@register' );

// define the admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function () {

    Route::get('dashboard', '\Backpack\Base\app\Http\Controllers\AdminController@dashboard')->name('crud.dashboard');
    Route::get('/', '\Backpack\Base\app\Http\Controllers\AdminController@dashboard')->name('crud.home');


    CRUD::resource( 'education', 'EducationCrudController' );
    CRUD::resource( 'school', 'SchoolCrudController' );
    CRUD::resource( 'user', 'UserCrudController' );
    CRUD::resource( 'candidate', 'CandidateCrudController' )->with(function(){
        Route::post( 'candidate/import', 'CandidateCrudController@import' )->name('crud.candidate.import');
    });

});


/*
 * Job
 */
Route::get('/job/{id}/apply/{title?}', 'JobController@apply')
  ->middleware(['role:candidate'])
  ->name('job_apply');

