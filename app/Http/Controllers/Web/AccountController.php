<?php

namespace App\Http\Controllers\Web;

use App\Models\Offer;
use GuzzleHttp\Client;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Exception\ClientException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\API\BaseController;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class AccountController extends Controller
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

        $this->middleware('auth')->except(['offerSent', 'payWithCard']);
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Current user account
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        // Select user API URL
        $current_user_id = isset(request()->user_id) ? request()->user_id : Auth::user()->id;
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . $current_user_id;
        // Select address by type and user API URL
        $legal_address_type = 'Adresse légale';
        $residence_type = 'Résidence actuelle';
        $url_legal_address = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/address/search/' . $legal_address_type . '/ ' . $current_user_id;
        $url_residence = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/address/search/' . $residence_type . '/ ' . $current_user_id;
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
            // Select user API response
            $response_user = $this::$client->request('GET', $url_user, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $user = json_decode($response_user->getBody(), false);
            // Select address by type and user API response
            $response_legal_address = $this::$client->request('GET', $url_legal_address, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $legal_address = json_decode($response_legal_address->getBody(), false);
            $response_residence = $this::$client->request('GET', $url_residence, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $residence = json_decode($response_residence->getBody(), false);
            // Select countries API response
            $response_country = $this::$client->request('GET', $url_country, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $country = json_decode($response_country->getBody(), false);
            // Select all received messages API response
            $response_message = $this::$client->request('GET', $url_message, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $messages = json_decode($response_message->getBody(), false);
            // Select types by group name API response
            $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $offer_type = json_decode($response_offer_type->getBody(), false);
            $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $transaction_type = json_decode($response_transaction_type->getBody(), false);
            $qr_code = QrCode::format('png')->merge((!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/assets/img/favicon/android-icon-96x96.png', 0.2, true)->size(135)->generate($user->data->phone);
            // $qr_code = QrCode::size(135)->generate($user->data->phone);

            if ($user->data->role_user->role->role_name != 'Administrateur' AND $user->data->role_user->role->role_name != 'Développeur' AND $user->data->role_user->role->role_name != 'Manager') {
                return view('account', [
                    'current_user' => $user->data,
                    'legal_address' => $legal_address->data,
                    'residence' => $residence->data,
                    'countries' => $country->data,
                    'messages' => $messages,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'qr_code' => $qr_code
                ]);

            } else {
                return view('dashboard.account', [
                    'current_user' => $user->data,
                    'legal_address' => $legal_address->data,
                    'residence' => $residence->data,
                    'countries' => $country->data,
                    'messages' => $messages,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'qr_code' => $qr_code
                ]);
            }

        } catch (ClientException $e) {
            // If the API returns some error, return to the page and display its message
            if ($user->data->role_user->role->role_name != 'Administrateur' AND $user->data->role_user->role->role_name != 'Développeur' AND $user->data->role_user->role->role_name != 'Manager') {
                return view('dashboard.account', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false)
                ]);

            } else {
                return view('account', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false)
                ]);
            }
        }
    }

    /**
     * GET: Current user account
     *
     * @param $amount
     * @param $user_id
     * @param $code
     * @return \Illuminate\View\View
     */
    public function offerSent($amount, $currency, $code, $user_id)
    {
      
        if ($code == '0') {
            // Register offer
            Offer::create([
                'amount' => $amount,
                'currency' => $currency,
                'type_id' => 8,
                'user_id' => $user_id
            ]);
            // Register notification
            Notification::create([
                'notification_url' => 'account/offers',
                'notification_content' => __('notifications.processing_succeed'),
                'status_id' => 7,
                'user_id' => $user_id
            ]);

            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.processing_succeed'),
            ]);
        }

        if ($code == '1') {
            $payment = Payment::where('order_number', Session::get('order_number'))->first();
          
                if ($payment != null) {
                    $payment->update([
                        'status_id' => 2,
                        'updated_at' => now()
                    ]);
                }
            // Register notification
            Notification::create([
                'notification_url' => 'account/offers',
                'notification_content' => __('notifications.process_canceled'),
                'status_id' => 7,
                'user_id' => $user_id
            ]);

            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.process_canceled'),
            ]);
        }

        if ($code == '2') {
            // Register offer
           $payment = Payment::where('order_number', Session::get('order_number'))->first();
          
                if ($payment != null) {
                    $payment->update([
                        'status_id' => 2,
                        'updated_at' => now()
                    ]);
                }
            // Register notification
            Notification::create([
                'notification_url' => 'account/offers',
                'notification_content' => __('notifications.process_failed'),
                'status_id' => 7,
                'user_id' => $user_id
            ]);

            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.process_failed'),
            ]);
        }
    }

    /**
     * GET: Run payment by bank card
     *
     * @param $amount
     * @param $currency
     * @param $user_id
     * @return \Illuminate\View\View
     */
    public function payWithCard($amount, $currency, $user_id)
    {
        $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-' . $user_id;
        // $gateway = 'https://beta-cardpayment.flexpay.cd/v1.1/pay';
        $gateway = 'https://cardpayment.flexpay.cd/v1.1/pay';
        $baseController = new BaseController();

        try {
            // Create response by sending request to FlexPay
            $response = $this::$client->request('POST', $gateway, [
                'headers' => array(
                    'Accept' => 'application/json'
                ),
                'json' => array(
                    // 'authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYyMjM0LCJzdWIiOiIyYmIyNjI4YzhkZTQ0ZWZjZjA1ODdmMGRmZjYzMmFjYyJ9.41n-SA4822KKo5aK14rPZv6EnKi9xJVDIMvksHG61nc',
                    'authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYxOTIzLCJzdWIiOiIyYzM2NzZkNDhkNGY4OTBhMGNiZjg4YmVjOTc1OTkyNyJ9.N7BBGQ2hNEeL_Q3gkvbyIQxcq71KtC_b0a4WsTKaMT8',
                    'merchant' => 'PROXDOC',
                    'reference' => $reference_code,
                    'amount' => $amount,
                    'currency' => $currency,
                    'description' => __('miscellaneous.bank_transaction_description'),
                    'callback_url' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/store',
                    'approve_url' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/account/offer_sent/' . $amount . '/' . $currency . '/0/' . $user_id,
                    'cancel_url' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/account/offer_sent/' . $amount . '/' . $currency . '/1/' . $user_id,
                    'decline_url' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/account/offer_sent/' . $amount . '/' . $currency . '/2/' . $user_id,
                ),
                'verify'  => false
            ]);
            $payment = json_decode($response->getBody(), false);
            $register=Payment::create([
                'orderNumber' => $payment->orderNumber,
                'amount' => $amount,
                'currency' => $currency,
                'type' => 2,
                'code' => 1,
            ]);

            if($register){
                return redirect($payment->url)->with('order_number',$payment->orderNumber);

            }else{
                return redirect('/account')->with('error_message', __('notifications.error_while_processing'));
            }

        } catch (ClientException $e) {
            $response_error = json_decode($e->getResponse()->getBody()->getContents(), false);

            return redirect('/account')->with('error_message', __('notifications.error_while_processing') . '<br>' . $response_error);
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Update account
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function updateAccount(Request $request)
    {
        // Select or Update current user API URL
        $url_user = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/' . Auth::user()->id;
        // Select address by type and user API URL
        $legal_address_type = 'Adresse légale';
        $residence_type = 'Résidence actuelle';
        $url_legal_address = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/address/search/' . $legal_address_type . '/ ' . Auth::user()->id;
        $url_residence = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/address/search/' . $residence_type . '/ ' . Auth::user()->id;
        // Update address API URL
        $url_update_address = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/address';
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
            // Select user API response
            $response_user = $this::$client->request('GET', $url_user, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $user = json_decode($response_user->getBody(), false);
            // Select address by type and user API response
            $response_legal_address = $this::$client->request('GET', $url_legal_address, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $legal_address = json_decode($response_legal_address->getBody(), false);
            $response_residence = $this::$client->request('GET', $url_residence, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $residence = json_decode($response_residence->getBody(), false);
            // Select countries API response
            $response_country = $this::$client->request('GET', $url_country, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $country = json_decode($response_country->getBody(), false);
            // Select all received messages API response
            $response_message = $this::$client->request('GET', $url_message, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $messages = json_decode($response_message->getBody(), false);
            // Select types by group name API response
            $response_offer_type = $this::$client->request('GET', $url_offer_type, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $offer_type = json_decode($response_offer_type->getBody(), false);
            $response_transaction_type = $this::$client->request('GET', $url_transaction_type, [
                'headers' => $this::$headers,
                'verify'  => false
            ]);
            $transaction_type = json_decode($response_transaction_type->getBody(), false);
            $qr_code = QrCode::format('png')->merge((!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/assets/img/favicon/android-icon-96x96.png', 0.2, true)->size(135)->generate($user->data->phone);
            // $qr_code = QrCode::size(135)->generate($user->data->phone);

            // Update user API response
            $response_update_user = $this::$client->request('PUT', $url_user, [
                'headers' => $this::$headers,
                'form_params' => [
                    'id' => $user->data->id,
                    'firstname' => $request->register_firstname,
                    'lastname' => $request->register_lastname,
                    'surname' => $request->register_surname,
                    'gender' => $request->register_gender,
                    'birth_city' => $request->register_birth_city,
                    'birth_date' => str_starts_with(app()->getLocale(), 'fr') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1],
                    'nationality' => $request->register_nationality,
                    'p_o_box' => $request->register_p_o_box,
                    'email' => $request->register_email,
                    'phone' => $request->register_phone,
                    'password' => $request->register_password,
                    'confirm_password' => $request->confirm_password
                ],
                'verify'  => false
            ]);
            $user = json_decode($response_update_user->getBody(), false);

            // Update legal address API response
            if ($request->register_legal_address_address_content_1) {
                $response_legal_address = $this::$client->request('POST', $url_update_address, [
                    'headers' => $this::$headers,
                    'form_params' => [
                        'address_content' => $request->register_legal_address_address_content_1,
                        'address_content_2' => $request->register_legal_address_address_content_2,
                        'neighborhood' => $request->register_legal_address_neighborhood,
                        'area' => $request->register_legal_address_area,
                        'city' => $request->register_legal_address_city,
                        'type_id' => 3,
                        'country_id' => $request->register_legal_address_country,
                        'user_id' => $user->data->id
                    ],
                    'verify'  => false
                ]);
                $legal_address = json_decode($response_legal_address->getBody(), false);
            }

            // Update residence API response
            if ($request->register_residence_address_content_1) {
                $response_residence = $this::$client->request('POST', $url_update_address, [
                    'headers' => $this::$headers,
                    'form_params' => [
                        'address_content' => $request->register_residence_address_content_1,
                        'address_content_2' => $request->register_residence_address_content_2,
                        'neighborhood' => $request->register_residence_neighborhood,
                        'area' => $request->register_residence_area,
                        'city' => $request->register_residence_city,
                        'type_id' => 4,
                        'country_id' => $request->register_residence_country,
                        'user_id' => $user->data->id
                    ],
                    'verify'  => false
                ]);
                $residence = json_decode($response_residence->getBody(), false);
            }

            if ($user->data->role_user->role->role_name != 'Administrateur' AND $user->data->role_user->role->role_name != 'Développeur' AND $user->data->role_user->role->role_name != 'Manager') {
                return view('account', [
                    'current_user' => $user->data,
                    'legal_address' => $legal_address->data,
                    'residence' => $residence->data,
                    'countries' => $country->data,
                    'messages' => $messages,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'qr_code' => $qr_code,
                    'alert_success' => __('miscellaneous.data_updated')
                ]);

            } else {
                return view('dashboard.account', [
                    'current_user' => $user->data,
                    'legal_address' => $legal_address->data,
                    'residence' => $residence->data,
                    'countries' => $country->data,
                    'messages' => $messages,
                    'offer_types' => $offer_type->data,
                    'transaction_types' => $transaction_type->data,
                    'qr_code' => $qr_code,
                    'alert_success' => __('miscellaneous.data_updated')
                ]);
            }

        } catch (ClientException $e) {
            // If the API returns some error, return to the page and display its message
            if ($user->data->role_user->role->role_name != 'Administrateur' AND $user->data->role_user->role->role_name != 'Développeur' AND $user->data->role_user->role->role_name != 'Manager') {
                return view('dashboard.account', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false)
                ]);

            } else {
                return view('account', [
                    'response_error' => json_decode($e->getResponse()->getBody()->getContents(), false)
                ]);
            }
        }
    }

    /**
     * POST: Update Identity document of a member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIdentityDoc(Request $request)
    {
        // Register image API URL
        $url_image = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/user/add_image/' . Auth::user()->id;

        try {
            // Register image API response
            $this::$client->request('PUT', $url_image, [
                'headers' => $this::$headers,
                'form_params' => [
                    'user_id' => Auth::user()->id,
                    'image_name' => $request->register_image_name,
                    'image_64_recto' => $request->data_recto,
                    'image_64_verso' => $request->data_verso,
                    'description' => $request->register_description
                ],
                'verify'  => false
            ]);

            return Redirect::back()->with('alert_success', __('miscellaneous.registered_data'));

        } catch (ClientException $e) {
            return Redirect::back()->with('response_error', (json_decode($e->getResponse()->getBody()->getContents(), false))->message);
        }
    }
}
