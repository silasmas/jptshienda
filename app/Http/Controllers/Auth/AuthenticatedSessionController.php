<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\ClientException;

class AuthenticatedSessionController extends Controller
{
    public static $headers;
    public static $client;

    public function __construct()
    {
        // Headers for API
        $this::$headers = [
            'Authorization' => 'Bearer uWNJB6EwpVQwSuL5oJ7S7JkSkLzdpt8M1Xrs1MZITE1bCEbjMhscv8ZX2sTiDBarCHcu1EeJSsSLZIlYjr6YCl7pLycfn2AAQmYm',
            'Accept' => 'application/json',
            'X-localization' => !empty(Session::get('locale')) ? Session::get('locale') : App::getLocale()
        ];
        // Client used for accessing API
        $this::$client = new Client();
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (!empty(Auth::user())) {
            return view('welcome');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
        // Get inputs
        $inputs = [
            'username' => $request->username,
            'password' => $request->password
        ];

        // Login user API URL
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/login';

        try {
            // Login country API response
            $response_user = $this::$client->request('POST', $url_user, [
                'headers' => $this::$headers,
                'form_params' => $inputs,
                'verify'  => false
            ]);
            $user = json_decode($response_user->getBody(), false);
            // Authentication datas (E-mail or Phone number)
            $auth_phone = Auth::attempt(['phone' => $user->data->phone, 'password' => $inputs['password']], $request->remember);
            $auth_email = Auth::attempt(['email' => $user->data->email, 'password' => $inputs['password']], $request->remember);

            if ($auth_phone || $auth_email) {
                $request->session()->regenerate();

                if (isset($user->data->role_user)) {
                    if ($user->data->role_user->role->role_name == 'Administrateur') {
                        return Redirect::route('home', ['user_role' => 'admin']);
    
                    } else if ($user->data->role_user->role->role_name == 'Développeur') {
                        return Redirect::route('home', ['user_role' => 'developer']);
    
                    } else if ($user->data->role_user->role->role_name == 'Manager') {
                        return Redirect::route('home', ['user_role' => 'manager']);
    
                    } else {
                        return Redirect::route('home');
                    }
                }
            }

        } catch (ClientException $e) {
            // If the API returns some error, return to the page and display its message
            return view('auth.login', [
                'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false),
                'inputs' => $inputs
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
