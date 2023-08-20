<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;
use App\Models\User;
use App\Models\Offer;
use App\Models\Status;
use App\Models\Notification;
use stdClass;
use Illuminate\Http\Request;
use App\Http\Resources\Offer as ResourcesOffer;
use GuzzleHttp\Exception\ClientException;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class OfferController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::orderByDesc('offer_name')->get();

        return $this->handleResponse(ResourcesOffer::collection($offers), __('notifications.find_all_offers_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status_unread = Status::where('status_name', 'Non lue')->first();
        // Client used for accessing API | Use authorization key
        $client = new Client();
        // $gateway = 'http://41.243.7.46:3006/api/rest/v1/paymentService';
        $gateway = 'https://backend.flexpay.cd/api/rest/v1/paymentService';
        // Get inputs
        $inputs = [
            'offer_name' => $request->offer_name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'type_id' => $request->offer_type_id,
            'user_id' => $request->user_id
        ];

        // Validate required fields
        if ($inputs['type_id'] == null OR $inputs['type_id'] == ' ') {
            return $this->handleError($inputs['type_id'], __('validation.required'), 400);
        }

        // If the amount is not given, there is no need to initiate the transaction
        if ($inputs['amount'] != null) {
            // If the phone number is set, use the mobile money
            if ($request->other_phone != null) {
                // If "user_id" is empty, then it's an anonymous offer
                if ($inputs['user_id'] != null) {
                    $current_user = User::find($inputs['user_id']);

                    if ($current_user != null) {
                        $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-' . $inputs['user_id'];

                        try {
                            // Create response by sending request to FlexPay
                            $response = $client->request('POST', $gateway, [
                                'headers' => array(
                                    // 'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYyMjM0LCJzdWIiOiIyYmIyNjI4YzhkZTQ0ZWZjZjA1ODdmMGRmZjYzMmFjYyJ9.41n-SA4822KKo5aK14rPZv6EnKi9xJVDIMvksHG61nc',
                                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYxOTIzLCJzdWIiOiIyYzM2NzZkNDhkNGY4OTBhMGNiZjg4YmVjOTc1OTkyNyJ9.N7BBGQ2hNEeL_Q3gkvbyIQxcq71KtC_b0a4WsTKaMT8',
                                    'Accept' => 'application/json'
                                ),
                                'json' => array(
                                    'merchant' => 'PROXDOC',
                                    'type' => $request->transaction_type_id,
                                    'phone' => $request->other_phone,
                                    'reference' => $reference_code,
                                    'amount' => $inputs['amount'],
                                    'currency' => $request->currency,
                                    'callbackUrl' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/store'
                                ),
                                'verify'  => false
                            ]);

                            // Decode JSON from the created response
                            $jsonRes = json_decode($response->getBody(), false);
                            $code = $jsonRes->code;

                            if ($code != '0') {
                                /*
                                    HISTORY AND/OR NOTIFICATION MANAGEMENT
                                */
                                Notification::create([
                                    'notification_url' => 'account/offers',
                                    'notification_content' => __('notifications.process_failed'),
                                    'status_id' => $status_unread->id,
                                    'user_id' => $current_user->id,
                                ]);        

                                return $this->handleError(__('notifications.process_failed'));

                            } else {
                                $object = new stdClass();

                                $object->result_response = [
                                    'message' => $jsonRes->message,
                                    'order_number' => $jsonRes->orderNumber
                                ];

                                // The offer is registered only if the processing succeed
                                $offer = Offer::create($inputs);

                                $object->offer = new ResourcesOffer($offer);

                                /*
                                    HISTORY AND/OR NOTIFICATION MANAGEMENT
                                */
                                Notification::create([
                                    'notification_url' => 'account/offers',
                                    'notification_content' => __('notifications.processing_succeed'),
                                    'status_id' => $status_unread->id,
                                    'user_id' => $current_user->id,
                                ]);        

                                return $this->handleResponse($object, __('notifications.create_offer_success'));
                            }

                        } catch (ClientException $e) {
                            $response_error = json_decode($e->getResponse()->getBody()->getContents(), false);

                            /*
                                HISTORY AND/OR NOTIFICATION MANAGEMENT
                            */
                            Notification::create([
                                'notification_url' => 'account/offers',
                                'notification_content' => __('notifications.error_while_processing'),
                                'status_id' => $status_unread->id,
                                'user_id' => $current_user->id,
                            ]);        

                            return $this->handleError($response_error, __('notifications.error_while_processing'));
                        }

                    } else {
                        return $this->handleError(__('notifications.find_user_404'));
                    }

                } else {
                    $reference_code = 'REF-' . ((string) random_int(10000000, 99999999)) . '-ANONYMOUS';

                    try {
                        // Create response by sending request to FlexPay
                        $response = $client->request('POST', $gateway, [
                            'headers' => array(
                                // 'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYyMjM0LCJzdWIiOiIyYmIyNjI4YzhkZTQ0ZWZjZjA1ODdmMGRmZjYzMmFjYyJ9.41n-SA4822KKo5aK14rPZv6EnKi9xJVDIMvksHG61nc',
                                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2MTYxOTIzLCJzdWIiOiIyYzM2NzZkNDhkNGY4OTBhMGNiZjg4YmVjOTc1OTkyNyJ9.N7BBGQ2hNEeL_Q3gkvbyIQxcq71KtC_b0a4WsTKaMT8',
                                'Accept' => 'application/json'
                            ),
                            'json' => array(
                                'merchant' => 'PROXDOC',
                                'type' => $request->transaction_type_id,
                                'phone' => $request->other_phone,
                                'reference' => $reference_code,
                                'amount' => $inputs['amount'],
                                'currency' => $request->currency,
                                'callbackUrl' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/payment/store'
                            ),
                            'verify'  => false
                        ]);
                        // Decode JSON from the created response
                        $jsonRes = json_decode($response->getBody(), false);
                        $code = $jsonRes->code;

                        if ($code != '0') {
                            return $this->handleError(__('notifications.process_failed'));

                        } else {
                            $object = new stdClass();

                            $object->result_response = [
                                'message' => $jsonRes->message,
                                'order_number' => $jsonRes->orderNumber
                            ];

                            // The offer is registered only if the processing succeed
                            $offer = Offer::create($inputs);

                            $object->offer = new ResourcesOffer($offer);

                            return $this->handleResponse($object, __('notifications.create_offer_success'));
                        }

                    } catch (ClientException $e) {
                        $response_error = json_decode($e->getResponse()->getBody()->getContents(), false);

                        return $this->handleError($response_error, __('notifications.error_while_processing'));
                    }
                }
            } else {
                $offer = Offer::create($inputs);

                return $this->handleResponse(new ResourcesOffer($offer), __('notifications.create_offer_success'));
            }

        } else {
            $offer = Offer::create($inputs);

            return $this->handleResponse(new ResourcesOffer($offer), __('notifications.create_offer_success'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::find($id);

        if (is_null($offer)) {
            return $this->handleError(__('notifications.find_offer_404'));
        }

        return $this->handleResponse(new ResourcesOffer($offer), __('notifications.find_offer_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'offer_name' => $request->offer_name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'type_id' => $request->type_id,
            'user_id' => $request->user_id,
            'updated_at' => now()
        ];

        if ($inputs['type_id'] == null OR $inputs['type_id'] == ' ') {
            return $this->handleError($inputs['type_id'], __('validation.required'), 400);
        }

        $offer->update($inputs);

        return $this->handleResponse(new ResourcesOffer($offer), __('notifications.update_offer_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        $offers = Offer::all();

        return $this->handleResponse(ResourcesOffer::collection($offers), __('notifications.delete_offer_success'));
    }
}
