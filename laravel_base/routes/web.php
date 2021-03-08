<?php

// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => 'setlocale'], function () {

  Route::get('/', function () {
    return redirect('login');
  })->name('welcome');

  Auth::routes(['verify' => true]);
  Route::get('home', 'HomeController@index')->name('home');

  Route::group(['middleware' => ['auth'], 'prefix' => 'march'], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'Group'], function () {
      Route::get('manage', 'GroupManageController@index')->name('group_manage');
      Route::get('edit/{group_id}', 'GroupManageController@createOrUpdate')->name('group_edit');
      Route::post('add', 'GroupManageController@add')->name('group_add');
      Route::post('remove', 'GroupManageController@remove')->name('group_remove');
      Route::post('create', 'GroupManageController@create')->name('group_create');
      Route::post('update', 'GroupManageController@update')->name('group_update');
      Route::post('delete', 'GroupManageController@delete')->name('group_delete');
    });
    Route::group(['prefix' => 'Note'], function () {
      Route::get('manage', 'NoteManageController@index')->name('note_manage');
      Route::get('edit/{group_id}/{note_id}', 'NoteManageController@edit')->name('note_edit');
      Route::get('read/{group_id}/{note_id}', 'NoteManageController@read')->name('note_read');
      Route::post('select', 'NoteManageController@select')->name('note_group_select');
      Route::post('create/{group_id}', 'NoteManageController@create')->name('note_create');
      Route::post('update', 'NoteManageController@update')->name('note_update');
      Route::post('delete', 'NoteManageController@delete')->name('note_delete');
    });
  });

  Route::get('/setlocale/{locale}', function ($locale) {
    session()->put(env('S_Locale'), $locale);
    return redirect()->back();
  })->name('locale');
});
