<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class HomeController extends Controller
{
    public static $headers;
    public static $client;

    public function __construct()
    {
        // Headers for API
        $this::$headers = [
            'Authorization' => 'Bearer uWNJB6EwpVQwSuL5oJ7S7JkSkLzdpt8M1Xrs1MZITE1bCEbjMhscv8ZX2sTiDBarCHcu1EeJSsSLZIlYjr6YCl7pLycfn2AAQmYm',
            'Accept' => 'application/json',
            'X-localization' => !empty(Session::get('locale')) ? Session::get('locale') : App::getLocale(),
        ];
        // Client used for accessing API
        $this::$client = new Client();

        $this->middleware('auth')->except(['changeLanguage', 'index', 'news', 'newsDatas', 'works', 'workDatas', 'donate', 'about', 'help', 'faq', 'termsOfUse', 'privacyPolicy', 'transactionWaiting', 'transactionMessage', 'registerOffer']);
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Change language
     *
     * @param  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    /**
     * GET: View dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select all users by role API URL
            $manager_role = 'Manager';
            $effective_member_role = 'Membre Effectif';
            $url_manager = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_role/' . $manager_role;
            $url_effective_member = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_role/' . $effective_member_role;
            // Select all users by not role API URL
            $developer_role = 'Développeur';
            $url_not_developer = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_not_role/' . $developer_role;
            // Select users by stauts "Désactivé" API URL
            $url_deactivated_users = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_status/5';
            // Select news by type ID API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';
            $url_communiques = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/6';
            $url_events = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/7';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select all users by role API response
                $response_effective_member = $this::$client->request('GET', $url_effective_member, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $effective_members = json_decode($response_effective_member->getBody(), false);
                $response_manager = $this::$client->request('GET', $url_manager, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $managers = json_decode($response_manager->getBody(), false);
                // Select all users by not role API response
                $response_not_developer = $this::$client->request('GET', $url_not_developer, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $not_developer = json_decode($response_not_developer->getBody(), false);
                // Select users by stauts "Désactivé" API response
                $response_deactivated_users = $this::$client->request('GET', $url_deactivated_users, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $deactivated_users = json_decode($response_deactivated_users->getBody(), false);
                // // Select news by type ID API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);
                $response_communiques = $this::$client->request('GET', $url_communiques, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $communiques = json_decode($response_communiques->getBody(), false);
                $response_events = $this::$client->request('GET', $url_events, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $events = json_decode($response_events->getBody(), false);

                if (isset(request()->user_role)) {
                    if (request()->user_role == 'admin') {
                        return view('dashboard', [
                            'current_user' => $user->data,
                            'countries' => $country->data,
                            'messages' => $messages->data,
                            'offer_types' => $offer_type->data,
                            'transaction_types' => $transaction_type->data,
                            'deactivated_users' => $deactivated_users->data,
                            'news' => $news->data,
                            'communiques' => $communiques->data,
                            'events' => $events->data,
                        ]);

                    } else if (request()->user_role == 'developer') {
                        return view('dashboard', [
                            'current_user' => $user->data,
                            'countries' => $country->data,
                            'messages' => $messages->data,
                            'offer_types' => $offer_type->data,
                            'transaction_types' => $transaction_type->data,
                        ]);

                    } else if (request()->user_role == 'manager') {
                        return view('dashboard', [
                            'current_user' => $user->data,
                            'countries' => $country->data,
                            'messages' => $messages->data,
                            'offer_types' => $offer_type->data,
                            'transaction_types' => $transaction_type->data,
                            'users_not_developer' => $not_developer->data,
                            'managers' => $managers->data,
                            'effective_members' => $effective_members->data,
                            'deactivated_users' => $deactivated_users->data,
                            'news' => $news->data,
                            'communiques' => $communiques->data,
                            'events' => $events->data,
                        ]);

                    } else {
                        return view('welcome', [
                            'current_user' => $user->data,
                            'countries' => $country->data,
                            'messages' => $messages->data,
                            'offer_types' => $offer_type->data,
                            'transaction_types' => $transaction_type->data,
                        ]);
                    }

                } else {
                    return view('welcome', [
                        'current_user' => $user->data,
                        'countries' => $country->data,
                        'messages' => $messages->data,
                        'offer_types' => $offer_type->data,
                        'transaction_types' => $transaction_type->data,
                    ]);
                }

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('welcome', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);

                return view('welcome', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('welcome', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Select current user API URL
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
        // Select all received messages API URL
        $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
        // Select all users by role API URL
        $manager_role = 'Manager';
        $effective_member_role = 'Membre Effectif';
        $url_manager = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_role/' . $manager_role;
        $url_effective_member = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_role/' . $effective_member_role;
        // Select all users by not role API URL
        $developer_role = 'Développeur';
        $url_not_developer = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_not_role/' . $developer_role;
        // Select users by stauts "Désactivé" API URL
        $url_deactivated_users = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/find_by_status/5';
        // Select news by type ID API URL
        $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';
        $url_communiques = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/6';
        $url_events = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/7';

        try {
            // Select current user API response
            $response_user = $this::$client->request('GET', $url_user, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $user = json_decode($response_user->getBody(), false);
            // Select all received messages API response
            $response_message = $this::$client->request('GET', $url_message, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $messages = json_decode($response_message->getBody(), false);
            // Select all users by role API response
            $response_effective_member = $this::$client->request('GET', $url_effective_member, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $effective_members = json_decode($response_effective_member->getBody(), false);
            $response_manager = $this::$client->request('GET', $url_manager, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $managers = json_decode($response_manager->getBody(), false);
            // Select all users by not role API response
            $response_not_developer = $this::$client->request('GET', $url_not_developer, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $not_developer = json_decode($response_not_developer->getBody(), false);
            // Select users by stauts "Désactivé" API response
            $response_deactivated_users = $this::$client->request('GET', $url_deactivated_users, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $deactivated_users = json_decode($response_deactivated_users->getBody(), false);
            // // Select news by type ID API response
            $response_news = $this::$client->request('GET', $url_news, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $news = json_decode($response_news->getBody(), false);
            $response_communiques = $this::$client->request('GET', $url_communiques, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $communiques = json_decode($response_communiques->getBody(), false);
            $response_events = $this::$client->request('GET', $url_events, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $events = json_decode($response_events->getBody(), false);

            if ($user->data->role_user->role->role_name != 'Administrateur' and $user->data->role_user->role->role_name != 'Développeur' and $user->data->role_user->role->role_name != 'Manager') {
                return Redirect::route('home');

            } else {
                return view('dashboard', [
                    'current_user' => $user->data,
                    'messages' => $messages->data,
                    'users_not_developer' => $not_developer->data,
                    'managers' => $managers->data,
                    'effective_members' => $effective_members->data,
                    'deactivated_users' => $deactivated_users->data,
                    'news' => $news->data,
                    'communiques' => $communiques->data,
                    'events' => $events->data,
                ]);
            }

        } catch (ClientException $e) {
            // If the API returns some error, return to the page and display its message
            return view('welcome', [
                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
            ]);
        }
    }

    /**
     * Display the About page.
     *
     * @return \Illuminate\View\View
     */
    public function notification()
    {
        // Select current user API URL
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
        // Mark all notification read API URL
        $url_notifications_read = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/notification/mark_all_read/' . Auth::user()->id;
        // Select all countries API URL
        $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
        // Select all received messages API URL
        $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
        // Select types by group name API URL
        $offer_type_group = 'Type d\'offre';
        $transaction_type_group = 'Type de transaction';
        $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
        $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;

        try {
            // Select current user API response
            $response_user = $this::$client->request('GET', $url_user, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $user = json_decode($response_user->getBody(), false);

            // Mark all notification read API response
            $this::$client->request('PUT', $url_notifications_read, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);

            // Select countries API response
            $response_country = $this::$client->request('GET', $url_country, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $country = json_decode($response_country->getBody(), false);
            // Select all received messages API response
            $response_message = $this::$client->request('GET', $url_message, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $messages = json_decode($response_message->getBody(), false);
            // Select types by group name API response
            $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $offer_type = json_decode($response_offer_type->getBody(), false);
            $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                'headers' => $this::$headers,
                'verify' => false,
            ]);
            $transaction_type = json_decode($response_transaction_type->getBody(), false);

            return view('notification', [
                'current_user' => $user->data,
                'countries' => $country->data,
                'messages' => $messages->data,
                'offer_types' => $offer_type->data,
                'transaction_types' => $transaction_type->data,
            ]);

        } catch (ClientException $e) {
            // If the API returns some error, return to the page and display its message
            return view('notification', [
                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
            ]);
        }
}

    /**
     * Display the About page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // About API URL
            $url_about_party = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/about_party';
            $url_about_app = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/about_app';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // About API response
                $response_about_party = $this::$client->request('GET', $url_about_party, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $about_party = json_decode($response_about_party->getBody(), false);
                $response_about_app = $this::$client->request('GET', $url_about_app, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $about_app = json_decode($response_about_app->getBody(), false);

                return view('about', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'about_party' => $about_party->data,
                    'about_app' => $about_app->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // About API URL
            $url_about_party = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/about_party';
            $url_about_app = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/about_app';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // About API response
                $response_about_party = $this::$client->request('GET', $url_about_party, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $about_party = json_decode($response_about_party->getBody(), false);
                $response_about_app = $this::$client->request('GET', $url_about_app, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $about_app = json_decode($response_about_app->getBody(), false);

                return view('about', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'about_party' => $about_party->data,
                    'about_app' => $about_app->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the help page.
     *
     * @return \Illuminate\View\View
     */
    public function help()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Help API URL
            $url_help = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/help_center';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Help API response
                $response_help = $this::$client->request('GET', $url_help, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $help = json_decode($response_help->getBody(), false);

                return view('about', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'help' => $help->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Help API URL
            $url_help = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/help_center';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Help API response
                $response_help = $this::$client->request('GET', $url_help, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $help = json_decode($response_help->getBody(), false);

                return view('about', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'help' => $help->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the FAQ page.
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // FAQ API URL
            $url_faq = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/faq';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // FAQ API response
                $response_faq = $this::$client->request('GET', $url_faq, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $faq = json_decode($response_faq->getBody(), false);

                return view('about', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'faq' => $faq->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // FAQ API URL
            $url_faq = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/faq';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // FAQ API response
                $response_faq = $this::$client->request('GET', $url_faq, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $faq = json_decode($response_faq->getBody(), false);

                return view('about', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'faq' => $faq->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the Terms of use page.
     *
     * @return \Illuminate\View\View
     */
    public function termsOfUse()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Terms of use API URL
            $url_terms = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/terms';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Terms of use API response
                $response_terms = $this::$client->request('GET', $url_terms, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $terms = json_decode($response_terms->getBody(), false);

                return view('about', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'terms' => $terms->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Terms of use API URL
            $url_terms = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/terms';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Terms of use API response
                $response_terms = $this::$client->request('GET', $url_terms, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $terms = json_decode($response_terms->getBody(), false);

                return view('about', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'terms' => $terms->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the Privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Privacy policy API URL
            $url_privacy_policy = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/privacy_policy';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Privacy policy API response
                $response_privacy_policy = $this::$client->request('GET', $url_privacy_policy, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $privacy_policy = json_decode($response_privacy_policy->getBody(), false);

                return view('about', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'privacy_policy' => $privacy_policy->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Privacy policy API URL
            $url_privacy_policy = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/about_subject/privacy_policy';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Privacy policy API response
                $response_privacy_policy = $this::$client->request('GET', $url_privacy_policy, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $privacy_policy = json_decode($response_privacy_policy->getBody(), false);

                return view('about', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'privacy_policy' => $privacy_policy->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('about', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the Privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function news()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select news by type API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by type API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);

                return view('news', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('news', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select news by type API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by type API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);

                return view('news', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('news', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the Privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function newsDatas($id)
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select news by ID API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/' . $id;
            // Select news by type API URL
            $url_other_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by ID API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);
                // Select news by type API response
                $response_other_news = $this::$client->request('GET', $url_other_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $other_news = json_decode($response_other_news->getBody(), false);

                return view('news', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                    'other_news' => $other_news->data,
                ]);

            } catch (ClientException $e) {
                $decoded_exception = json_decode($e->getResponse()->getBody()->getContents(), false);

                // If the API returns some error, return to the page and display its message
                return Redirect::route('news.home')->with('exception', $decoded_exception->message);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select news by ID API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/' . $id;
            // Select news by type API URL
            $url_other_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/5';

            try {
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by ID API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);
                // Select news by type API response
                $response_other_news = $this::$client->request('GET', $url_other_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $other_news = json_decode($response_other_news->getBody(), false);

                return view('news', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                    'other_news' => $other_news->data,
                ]);

            } catch (ClientException $e) {
                $decoded_exception = json_decode($e->getResponse()->getBody()->getContents(), false);

                // If the API returns some error, return to the page and display its message
                return Redirect::route('news.home')->with('exception', $decoded_exception->message);
            }
        }
    }

    /**
     * Display the Events page.
     *
     * @return \Illuminate\View\View
     */
    public function works()
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select news by not type API URL
            $url_not_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_not_type/5';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by not type API response
                $response_news = $this::$client->request('GET', $url_not_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $not_news = json_decode($response_news->getBody(), false);

                return view('works', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $not_news->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('works', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select news by type API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/7';

            try {
                // Select all countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by not type API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);

                return view('works', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                ]);

            } catch (ClientException $e) {
                // If the API returns some error, return to the page and display its message
                return view('news', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                ]);
            }
        }
    }

    /**
     * Display the Privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function workDatas($id)
    {
        if (!empty(Auth::user())) {
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select all received messages API URL
            $url_message = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/message/inbox/' . Auth::user()->id;
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select current user API URL
            $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
            // Select news by ID API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/' . $id;
            // Select news by not type API URL
            $url_other_not_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_not_type/5';

            try {
                // Select current user API response
                $response_user = $this::$client->request('GET', $url_user, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $user = json_decode($response_user->getBody(), false);
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select all received messages API response
                $response_message = $this::$client->request('GET', $url_message, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $messages = json_decode($response_message->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by ID API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);
                // Select news by not type API response
                $response_other_not_news = $this::$client->request('GET', $url_other_not_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $other_not_news = json_decode($response_other_not_news->getBody(), false);

                return view('works', [
                    'current_user' => $user->data,
                    'countries' => $country->data,
                    'messages' => $messages->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                    'other_news' => $other_not_news->data,
                ]);

            } catch (ClientException $e) {
                $decoded_exception = json_decode($e->getResponse()->getBody()->getContents(), false);

                // If the API returns some error, return to the page and display its message
                return Redirect::route('works')->with('exception', $decoded_exception->message);
            }

        } else {
            // Select all countries API URL
            $url_country = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/country';
            // Select types by group name API URL
            $offer_type_group = 'Type d\'offre';
            $transaction_type_group = 'Type de transaction';
            $url_offer_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $offer_type_group;
            $url_transaction_type = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/type/find_by_group/' . $transaction_type_group;
            // Select news by ID API URL
            $url_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/' . $id;
            // Select news by type API URL
            $url_other_news = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/news/select_by_type/7';

            try {
                // Select countries API response
                $response_country = $this::$client->request('GET', $url_country, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $country = json_decode($response_country->getBody(), false);
                // Select types by group name API response
                $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $offer_type = json_decode($response_offer_type->getBody(), false);
                $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $transaction_type = json_decode($response_transaction_type->getBody(), false);
                // Select news by ID API response
                $response_news = $this::$client->request('GET', $url_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $news = json_decode($response_news->getBody(), false);
                // Select news by type API response
                $response_other_news = $this::$client->request('GET', $url_other_news, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $other_news = json_decode($response_other_news->getBody(), false);

                return view('works', [
                    'countries' => $country->data,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'news' => $news->data,
                    'other_news' => $other_news->data,
                ]);

            } catch (ClientException $e) {
                $decoded_exception = json_decode($e->getResponse()->getBody()->getContents(), false);

                // If the API returns some error, return to the page and display its message
                return Redirect::route('works')->with('exception', $decoded_exception->message);
            }
        }
    }

    /**
     * Display the message about transaction in waiting.
     *
     * @return \Illuminate\View\View
     */
    public function transactionWaiting()
    {
        return view('transaction_message');
    }

    /**
     * Display the message about transaction done.
     *
     * @return \Illuminate\View\View
     */
    public function transactionMessage($order_number, $user_id, $password)
    {
        // Find payment API URL
        $url_payment1 = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/find_by_order_number/' . $order_number;
        $url_payment2 = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/find_by_order_number_user/' . $order_number . '/' . $user_id;

        try {
            if ($user_id == 0) {
                // Find payment API Response
                $response_payment1 = $this::$client->request('GET', $url_payment1, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $payment1 = json_decode($response_payment1->getBody(), false);

                if ($password != 'no') {
                    return view('transaction_message', [
                        'message_content' => __('miscellaneous.transaction_done'),
                        'message_new_partner' => __('miscellaneous.new_partner_message') . ' ' . $password,
                        'status_code' => (string) $payment1->data->status->id,
                        'payment' => $payment1->data,
                    ]);

                } else {
                    return view('transaction_message', [
                        'message_content' => __('miscellaneous.transaction_done'),
                        'status_code' => (string) $payment1->data->status->id,
                        'payment' => $payment1->data,
                    ]);
                }

            } else {
                // Find payment API Response
                $response_payment2 = $this::$client->request('GET', $url_payment2, [
                    'headers' => $this::$headers,
                    'verify' => false,
                ]);
                $payment2 = json_decode($response_payment2->getBody(), false);

                if ($password != 'no') {
                    return view('transaction_message', [
                        'message_content' => __('miscellaneous.transaction_done'),
                        'message_new_partner' => __('miscellaneous.new_partner_message') . ' ' . $password,
                        'status_code' => (string) $payment2->data->status->id,
                        'payment' => $payment2->data,
                    ]);

                } else {
                    return view('transaction_message', [
                        'message_content' => __('miscellaneous.transaction_done'),
                        'status_code' => (string) $payment2->data->status->id,
                        'payment' => $payment2->data,
                    ]);
                }
            }

        } catch (ClientException $e) {
            return view('transaction_message', [
                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                'message_content' => __('miscellaneous.transaction_failed'),
                'status_code' => '2',
            ]);
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Register offer
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerOffer(Request $request)
    {
        // Register offer API URL
        $url_offer = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/offer/store';
        // Register payment API URL
        $url_payment = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/store';
        // Select all users or Register user API URL
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user';
        $inputs_user = [
            'firstname' => $request->register_firstname,
            'lastname' => $request->register_lastname,
            'phone' => $request->select_country_user . $request->phone_number_user,
            'email' => $request->register_email,
            'role_id' => 9,
            'status_id' => 3,
        ];

        if (!empty(Auth::user())) {
            $inputs_offer = [
                'offer_name' => $request->register_offer_name,
                'amount' => $request->register_amount,
                'offer_type_id' => $request->offer_type_id,
                'user_id' => Auth::user()->id,
                'other_phone' => $request->select_country . $request->other_phone_number,
                'transaction_type_id' => $request->transaction_type_id,
                'currency' => $request->select_currency,
            ];

            if ($inputs_offer['transaction_type_id'] == null) {
                return Redirect::back()->with('error_message', __('miscellaneous.transaction_type_error'));
            }

            if ($inputs_offer['transaction_type_id'] != null) {
                if ($inputs_offer['transaction_type_id'] == 1) {
                    if ($request->select_country == null or $request->other_phone_number == null) {
                        return Redirect::back()->with('error_message', __('validation.custom.phone.incorrect'));
                    }

                    try {
                        // Register offer API Response
                        $response_offer = $this::$client->request('POST', $url_offer, [
                            'headers' => $this::$headers,
                            'form_params' => $inputs_offer,
                            'verify' => false,
                        ]);
                        $offer = json_decode($response_offer->getBody(), false);
                        $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-' . Auth::user()->id;

                        // Register payment API Response
                        $this::$client->request('POST', $url_payment, [
                            'headers' => $this::$headers,
                            'form_params' => [
                                'reference' => $reference_code,
                                'orderNumber' => $offer->data->result_response->order_number,
                                'amount' => $inputs_offer['amount'],
                                'phone' => $inputs_offer['other_phone'],
                                'currency' => $inputs_offer['currency'],
                                'type' => $inputs_offer['transaction_type_id'],
                                'code' => 1,
                                'user_id' => Auth::user()->id,
                            ],
                            'verify' => false,
                        ]);

                        return Redirect::route('transaction.waiting', [
                            'success_message' => $offer->data->result_response->order_number . '-' . Auth::user()->id . '-no',
                        ]);

                    } catch (ClientException $e) {
                        return view('transaction_message', [
                            'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                        ]);
                    }
                }

                if ($inputs_offer['transaction_type_id'] == 2) {
                    if ($inputs_offer['offer_type_id'] != '10') {
                        return Redirect::to('/account/offers/' . $inputs_offer['amount'] . '/' . $inputs_offer['currency'] . '/' . Auth::user()->id);

                    }

                    if ($inputs_offer['offer_type_id'] != '9') {
                        return Redirect::to('/account/offers/' . $inputs_offer['amount'] . '/' . $inputs_offer['currency'] . '/0');
                    }
                }
            }

        } else {
            if ($request->transaction_type_id == null) {
                return Redirect::back()->with('error_message', __('miscellaneous.transaction_type_error'));
            }

            if ($request->select_country == null || $request->other_phone_number == null || $request->select_currency == null) {
                return Redirect::back()->with('error_message', __('miscellaneous.required_fields'));
            }

            if ($request->transaction_type_id != null) {
                if ($request->transaction_type_id == 1) {
                    if ($request->select_country == null || $request->other_phone_number == null || $request->select_currency == null) {
                        return Redirect::back()->with('error_message', __('miscellaneous.required_fields'));
                    }
                    if ($inputs_user['firstname'] != null or $inputs_user['lastname'] != null or $inputs_user['phone'] != null) {
                        try {
                            // Select all users API Response
                            $response_user = $this::$client->request('GET', $url_user, [
                                'headers' => $this::$headers,
                                'verify' => false,
                            ]);
                            $users = json_decode($response_user->getBody(), false);

                            foreach ($users->data as $user):
                                if ($user->phone == $inputs_user['phone'] or $user->email == $inputs_user['email']) {
                                    // Register offer API Response
                                    $response_offer = $this::$client->request('POST', $url_offer, [
                                        'headers' => $this::$headers,
                                        'form_params' => [
                                            'offer_name' => $request->register_offer_name,
                                            'amount' => $request->register_amount,
                                            'offer_type_id' => $request->offer_type_id,
                                            'user_id' => $user->id,
                                            'other_phone' => $request->select_country . $request->other_phone_number,
                                            'transaction_type_id' => $request->transaction_type_id,
                                            'currency' => $request->select_currency,
                                        ],
                                        'verify' => false,
                                    ]);
                                    $offer = json_decode($response_offer->getBody(), false);
                                    $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-' . $user->id;

                                    // Register payment API Response
                                    $this::$client->request('POST', $url_payment, [
                                        'headers' => $this::$headers,
                                        'form_params' => [
                                            'reference' => $reference_code,
                                            'orderNumber' => $offer->data->result_response->order_number,
                                            'amount' => $request->register_amount,
                                            'phone' => $request->select_country . $request->other_phone_number,
                                            'currency' => $request->select_currency,
                                            'type' => $request->transaction_type_id,
                                            'code' => 1,
                                            'user_id' => $user->id,
                                        ],
                                        'verify' => false,
                                    ]);

                                    return Redirect::route('transaction.waiting', [
                                        'success_message' => $offer->data->result_response->order_number . '-' . $user->id . '-no',
                                    ]);
                                }
                            endforeach;

                            // Register user API Response
                            $response_user = $this::$client->request('POST', $url_user, [
                                'headers' => $this::$headers,
                                'form_params' => $inputs_user,
                                'verify' => false,
                            ]);
                            $user = json_decode($response_user->getBody(), false);
                            // Register offer API Response
                            $response_offer = $this::$client->request('POST', $url_offer, [
                                'headers' => $this::$headers,
                                'form_params' => [
                                    'offer_name' => $request->register_offer_name,
                                    'amount' => $request->register_amount,
                                    'offer_type_id' => $request->offer_type_id,
                                    'user_id' => $user->data->user->id,
                                    'other_phone' => $request->select_country . $request->other_phone_number,
                                    'transaction_type_id' => $request->transaction_type_id,
                                    'currency' => $request->select_currency,
                                ],
                                'verify' => false,
                            ]);
                            $offer = json_decode($response_offer->getBody(), false);
                            $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-' . $user->data->user->id;

                            // Register payment API Response
                            $this::$client->request('POST', $url_payment, [
                                'headers' => $this::$headers,
                                'form_params' => [
                                    'reference' => $reference_code,
                                    'orderNumber' => $offer->data->result_response->order_number,
                                    'amount' => $request->register_amount,
                                    'phone' => $request->select_country . $request->other_phone_number,
                                    'currency' => $request->select_currency,
                                    'type' => $request->transaction_type_id,
                                    'code' => 1,
                                    'user_id' => $user->data->user->id,
                                ],
                                'verify' => false,
                            ]);

                            return Redirect::route('transaction.waiting', [
                                'success_message' => $offer->data->result_response->order_number . '-' . $user->data->user->id . '-' . $user->data->password_reset->former_password,
                            ]);

                        } catch (ClientException $e) {
                            return view('transaction_message', [
                                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                                'status_code' => '2',
                            ]);
                        }

                    } else {
                        try {
                            // Register offer API Response
                            $response_offer = $this::$client->request('POST', $url_offer, [
                                'headers' => $this::$headers,
                                'form_params' => [
                                    'offer_name' => $request->register_offer_name,
                                    'amount' => $request->register_amount,
                                    'offer_type_id' => $request->offer_type_id,
                                    'other_phone' => $request->select_country . $request->other_phone_number,
                                    'transaction_type_id' => $request->transaction_type_id,
                                    'currency' => $request->select_currency,
                                ],
                                'verify' => false,
                            ]);
                            $offer = json_decode($response_offer->getBody(), false);
                            $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-ANONYMOUS';

                            // Register payment API Response
                            $this::$client->request('POST', $url_payment, [
                                'headers' => $this::$headers,
                                'form_params' => [
                                    'reference' => $reference_code,
                                    'orderNumber' => $offer->data->result_response->order_number,
                                    'amount' => $request->register_amount,
                                    'phone' => $request->select_country . $request->other_phone_number,
                                    'currency' => $request->select_currency,
                                    'type' => $request->transaction_type_id,
                                    'code' => 1,
                                ],
                                'verify' => false,
                            ]);

                            return Redirect::route('transaction.waiting', [
                                'success_message' => $offer->data->result_response->order_number . '-0-no',
                            ]);

                        } catch (ClientException $e) {
                            return view('transaction_message', [
                                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                                'status_code' => '2',
                            ]);
                        }
                    }
                }

                if ($request->transaction_type_id == 2) {
                    if ($request->select_currency == null) {
                        return Redirect::back()->with('error_message', __('miscellaneous.required_fields'));
                    }
                    if ($inputs_user['firstname'] != null or $inputs_user['lastname'] != null or $inputs_user['phone'] != null) {
                        // Register user API Response
                        $response_user = $this::$client->request('POST', $url_user, [
                            'headers' => $this::$headers,
                            'form_params' => $inputs_user,
                            'verify' => false,
                        ]);
                        $user = json_decode($response_user->getBody(), false);

                        return Redirect::to('/account/offers/' . $request->register_amount . '/' . $request->select_currency . '/' . $user->data->user->id);

                    } else {
                        return Redirect::to('/account/offers/' . $request->register_amount . '/' . $request->select_currency . '/0');
                    }
                }
            }
        }
    }
}
