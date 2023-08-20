<?php
/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
|--------------------------------------------------------------------------
| ROUTES FOR EVERY ROLES
|--------------------------------------------------------------------------
*/
// Generate symbolic link
Route::get('/symlink', function () {return view('symlink');})->name('generate_symlink');
// Home
Route::get('/', 'App\Http\Controllers\Web\HomeController@index')->name('home');
Route::get('/language/{locale}', 'App\Http\Controllers\Web\HomeController@changeLanguage')->name('change_language');
// Account
Route::get('/account', 'App\Http\Controllers\Web\AccountController@account')->name('account');
Route::get('/account/offers', 'App\Http\Controllers\Web\AccountController@account')->name('account.offers');
Route::get('/update_password', 'App\Http\Controllers\Web\AccountController@editPassword')->name('account.update.password');
Route::post('/account', 'App\Http\Controllers\Web\AccountController@updateAccount');
Route::post('/update_password', 'App\Http\Controllers\Web\AccountController@updatePassword');
Route::post('/update_identity_doc', 'App\Http\Controllers\Web\AccountController@updateIdentityDoc')->name('account.update.identity_doc');
// Message
Route::get('/message', 'App\Http\Controllers\Web\MessageController@receivedMessages')->name('message.inbox');
Route::get('/message/{id}', 'App\Http\Controllers\Web\MessageController@showMessage')->whereNumber('id')->name('message.datas');
Route::get('/message_sent', 'App\Http\Controllers\Web\MessageController@sentMessages')->name('message.outbox');
Route::get('/message_drafts', 'App\Http\Controllers\Web\MessageController@draftsMessages')->name('message.draft');
Route::get('/message_spams', 'App\Http\Controllers\Web\MessageController@spamsMessages')->name('message.spams');
Route::get('/message_new', 'App\Http\Controllers\Web\MessageController@newMessage')->name('message.new');
Route::get('/message_search/{data}', 'App\Http\Controllers\Web\MessageController@search')->name('message.search');
Route::get('/message_delete/{id}', 'App\Http\Controllers\Web\MessageController@deleteMessage')->name('message.delete');
Route::post('/message', 'App\Http\Controllers\Web\MessageController@storeMessage');
Route::post('/message/{id}', 'App\Http\Controllers\Web\MessageController@updateMessage')->whereNumber('id');
// Notification
Route::get('/notification', 'App\Http\Controllers\Web\HomeController@notification')->name('notification.home');
// Transaction
Route::get('/transaction_waiting', 'App\Http\Controllers\Web\HomeController@transactionWaiting')->name('transaction.waiting');
Route::get('/transaction_message/{orderNumber}/{userId}/{password}', 'App\Http\Controllers\Web\HomeController@transactionMessage')->whereNumber('userId')->name('transaction.message');

/*
|--------------------------------------------------------------------------
| ROUTES FOR EVERY ROLES EXCEPT "Administrateur" AND "Développeur"
|--------------------------------------------------------------------------
*/
// About
Route::get('/about', 'App\Http\Controllers\Web\HomeController@about')->name('about.home');
Route::get('/about/help', 'App\Http\Controllers\Web\HomeController@help')->name('about.help');
Route::get('/about/faq', 'App\Http\Controllers\Web\HomeController@faq')->name('about.faq');
Route::get('/about/terms_of_use', 'App\Http\Controllers\Web\HomeController@termsOfUse')->name('about.terms_of_use');
Route::get('/about/privacy_policy', 'App\Http\Controllers\Web\HomeController@privacyPolicy')->name('about.privacy_policy');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Administrateur"
|--------------------------------------------------------------------------
*/
// Home
Route::get('/admin', 'App\Http\Controllers\Web\HomeController@dashboard')->name('admin');
// Legal info
Route::get('/legal_info', 'App\Http\Controllers\Web\LegalInfoController@index')->name('legal_info.home');
Route::get('/legal_info/{id}', 'App\Http\Controllers\Web\LegalInfoController@show')->whereNumber('id')->name('legal_info.datas');
Route::get('/legal_info/{entity}', 'App\Http\Controllers\Web\LegalInfoController@indexEntity')->name('legal_info.entity.home');
Route::get('/legal_info/{entity}/{id}', 'App\Http\Controllers\Web\LegalInfoController@showEntity')->whereNumber('id')->name('legal_info.entity.datas');
Route::get('/legal_info/search/{data}', 'App\Http\Controllers\Web\LegalInfoController@search')->name('legal_info.search');
Route::get('/legal_info/{entity}/search/{data}', 'App\Http\Controllers\Web\LegalInfoController@searchEntity')->name('legal_info.entity.search');
Route::get('/legal_info/delete/{id}', 'App\Http\Controllers\Web\LegalInfoController@delete')->name('legal_info.delete');
Route::get('/legal_info/{entity}/delete/{id}', 'App\Http\Controllers\Web\LegalInfoController@deleteEntity')->name('legal_info.entity.delete');
Route::post('/legal_info', 'App\Http\Controllers\Web\LegalInfoController@store');
Route::post('/legal_info/{id}', 'App\Http\Controllers\Web\LegalInfoController@update')->whereNumber('id');
Route::post('/legal_info/{entity}', 'App\Http\Controllers\Web\LegalInfoController@storeEntity');
Route::post('/legal_info/{entity}/{id}', 'App\Http\Controllers\Web\LegalInfoController@updateEntity')->whereNumber('id');
// Country
Route::get('/country', 'App\Http\Controllers\Web\CountryController@index')->name('country.home');
Route::get('/country/{id}', 'App\Http\Controllers\Web\CountryController@show')->whereNumber('id')->name('country.datas');
Route::get('/country/search/{data}', 'App\Http\Controllers\Web\CountryController@search')->name('country.search');
Route::get('/country/delete/{id}', 'App\Http\Controllers\Web\CountryController@delete')->name('country.delete');
Route::post('/country', 'App\Http\Controllers\Web\CountryController@store');
Route::post('/country/{id}', 'App\Http\Controllers\Web\CountryController@update')->whereNumber('id');
// Miscellaneous
Route::get('/miscellaneous', 'App\Http\Controllers\Web\MiscellaneousController@index')->name('miscellaneous.home');
Route::get('/miscellaneous/{id}', 'App\Http\Controllers\Web\MiscellaneousController@show')->whereNumber('id')->name('miscellaneous.datas');
Route::get('/miscellaneous/{entity}', 'App\Http\Controllers\Web\MiscellaneousController@indexEntity')->name('miscellaneous.entity.home');
Route::get('/miscellaneous/{entity}/{id}', 'App\Http\Controllers\Web\MiscellaneousController@showEntity')->whereNumber('id')->name('miscellaneous.entity.datas');
Route::get('/miscellaneous/search/{data}', 'App\Http\Controllers\Web\MiscellaneousController@search')->name('miscellaneous.search');
Route::get('/miscellaneous/{entity}/search/{data}', 'App\Http\Controllers\Web\MiscellaneousController@searchEntity')->name('miscellaneous.entity.search');
Route::get('/miscellaneous/delete/{id}', 'App\Http\Controllers\Web\MiscellaneousController@delete')->name('miscellaneous.delete');
Route::get('/miscellaneous/{entity}/delete/{id}', 'App\Http\Controllers\Web\MiscellaneousController@deleteEntity')->name('miscellaneous.entity.delete');
Route::post('/miscellaneous', 'App\Http\Controllers\Web\MiscellaneousController@store');
Route::post('/miscellaneous/{id}', 'App\Http\Controllers\Web\MiscellaneousController@update')->whereNumber('id');
Route::post('/miscellaneous/{entity}', 'App\Http\Controllers\Web\MiscellaneousController@storeEntity');
Route::post('/miscellaneous/{entity}/{id}', 'App\Http\Controllers\Web\MiscellaneousController@updateEntity')->whereNumber('id');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Développeur"
|--------------------------------------------------------------------------
*/
// Home
Route::get('/developer', 'App\Http\Controllers\Web\HomeController@dashboard')->name('developer');
// API
Route::get('/apis', 'App\Http\Controllers\Web\APIController@index')->name('apis.home');
Route::get('/apis/{entity}', 'App\Http\Controllers\Web\APIController@apisEntity')->name('apis.entity');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Manager"
|--------------------------------------------------------------------------
*/
// Home
Route::get('/manager', 'App\Http\Controllers\Web\HomeController@dashboard')->name('manager');
// Party
Route::get('/members', 'App\Http\Controllers\Web\PartyController@members')->name('party.member.home');
Route::post('/members/new', 'App\Http\Controllers\Web\PartyController@memberAdd')->name('party.member.new');
Route::get('/members/{id}', 'App\Http\Controllers\Web\PartyController@memberDatas')->whereNumber('id')->name('party.member.datas');
Route::post('/members/{id}', 'App\Http\Controllers\Web\PartyController@updateMember')->whereNumber('id')->name('party.member.update');
Route::post('/members/new/check_token', 'App\Http\Controllers\Web\PartyController@checkToken')->name('party.member.new.check_token');
Route::get('/members/{id}/print_card', 'App\Http\Controllers\Web\PartyController@printCard')->whereNumber('id')->name('party.member.print_card');
Route::get('/members/{id}/notif_messages', 'App\Http\Controllers\Web\PartyController@memberNotifMessages')->whereNumber('id')->name('party.member.notif_message');
Route::post('/members/{id}/update_identity_doc', 'App\Http\Controllers\Web\PartyController@updateIdentityDoc')->whereNumber('id')->name('party.member.identity_doc');
Route::get('/members/search/{data}', 'App\Http\Controllers\Web\PartyController@searchMember')->name('members.search');
Route::post('/members/send_notif_message', 'App\Http\Controllers\Web\PartyController@sendNotifMessage')->name('members.send_notif_message');
Route::delete('/members/{id}/notif_messages/{notif_id}', 'App\Http\Controllers\Web\PartyController@deleteNotifMessage')->whereNumber(['id', 'notif_id'])->name('party.member.delete_notif_message');
Route::get('/managers', 'App\Http\Controllers\Web\PartyController@managers')->name('party.managers');
Route::get('/managers/new', 'App\Http\Controllers\Web\PartyController@managerAdd')->name('party.manager.new');
Route::get('/managers/{id}', 'App\Http\Controllers\Web\PartyController@memberDatas')->whereNumber('id')->name('party.manager.datas');
Route::get('/infos', 'App\Http\Controllers\Web\PartyController@infos')->name('party.infos');
Route::get('/infos/{entity}', 'App\Http\Controllers\Web\PartyController@infoEntity')->name('party.infos.entity');
Route::post('/infos/new', 'App\Http\Controllers\Web\PartyController@newInfo')->name('party.infos.new');
Route::get('/infos/{entity}/{id}', 'App\Http\Controllers\Web\PartyController@infoEntityDatas')->whereNumber('id')->name('party.infos.entity.datas');
Route::post('/infos/{entity}/{id}', 'App\Http\Controllers\Web\PartyController@updateInfo')->whereNumber('id');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Membre"
|--------------------------------------------------------------------------
*/
// Home
Route::get('/news', 'App\Http\Controllers\Web\HomeController@news')->name('news.home');
Route::get('/news/{id}', 'App\Http\Controllers\Web\HomeController@newsDatas')->whereNumber('id')->name('news.datas');
Route::get('/communique', 'App\Http\Controllers\Web\HomeController@communique')->name('communique.home');
Route::get('/communique/{id}', 'App\Http\Controllers\Web\HomeController@communiqueDatas')->whereNumber('id')->name('communique.datas');
Route::get('/works', 'App\Http\Controllers\Web\HomeController@works')->name('works');
Route::get('/works/{id}', 'App\Http\Controllers\Web\HomeController@workDatas')->whereNumber('id')->name('work.datas');
Route::get('/donate', 'App\Http\Controllers\Web\HomeController@donate')->name('donate');
Route::post('/donate', 'App\Http\Controllers\Web\HomeController@registerOffer');
// Account
Route::get('/account/offers/{amount}/{currency}/{user_id}', 'App\Http\Controllers\Web\AccountController@payWithCard')->whereNumber(['amount', 'user_id'])->name('account.pay_with_card');
Route::get('/account/offer_sent/{amount}/{currency}/{code}/{user_id}', 'App\Http\Controllers\Web\AccountController@offerSent')->whereNumber(['amount', 'code', 'user_id'])->name('account.offer_sent');

require __DIR__.'/auth.php';
