<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Models\ApiProvider;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Services\changeOrderStatusService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class ApiController extends Controller
{
    use Notify;

    public function place_order()
    {
        return Order::all();
    }

    public function apiV1(Request $request)
    {
        $req = Purify::clean($request->all());
        $validator = Validator::make($req, [
            'key' => 'required',
            'action' => 'required|in:balance,services,add,status,orders,smscode',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $actionList = ['balance', 'services', 'add', 'status', 'orders', 'smscode'];
        if (!in_array($req['action'], $actionList)) {
            return response()->json(['errors' => ['action' => "Invalid request action"]], 422);
        }

        $user = User::where('api_token', $req['key'])->first(['id', 'api_token', 'status', 'balance','username']);
        if (!$user) {
            return response()->json(['errors' => ['key' => "Invalid Key"]], 422);
        }
        if ($user->status == 0) {
            return response()->json(['errors' => ['message' => "This credential is no longer"]], 422);
        }


        $basic = (object)config('basic');
        if (strtolower($req['action']) == 'balance') {
            $result['status'] = 'success';
            $result['balance'] = $user->balance;
            $result['currency'] = $basic->currency;
            return response()->json($result, 200);

        } elseif (strtolower($req['action']) == 'services') {
            $result = Service::where('service_status', 1)->orderBy('category_id', 'asc')->get()
                ->map(function ($service) {
                    return [
                        'service' => $service->id,
                        'name' => $service->service_title,
                        'category' => optional($service->category)->category_title,
                        'rate' => $service->price,
                        'min' => $service->min_amount,
                        'max' => $service->max_amount
                    ];
                });
            return response()->json($result, 200);

        } elseif (strtolower($req['action']) == 'add') {
            $validator = Validator::make($req, [
                'service' => 'required',
                'link' => '',
                'quantity' => 'integer'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $service = Service::where('id', $req['service'])->where('service_status', 1)->first();
            if (!$service) {
                return response()->json(['errors' => ['message' => "Invalid Service"]], 422);
            }
            Auth::login($user);
            $response = app('App\Http\Controllers\User\OrderController')->store($request, $user);
            return $response;
//            $quantity = $req['quantity'];
//            if ($service->drip_feed == 1) {
//                $rules['runs'] = 'required|integer|not_in:0';
//                $rules['interval'] = 'required|integer|not_in:0';
//                $validator = Validator::make($req, $rules);
//                if ($validator->fails()) {
//                    return response()->json(['errors' => $validator->errors()], 422);
//                }
//                $quantity = $req['quantity'] * $req['runs'];
//            }
//            if ($service->min_amount <= $quantity && $service->max_amount >= $quantity) {
//                $price = round(($quantity * $service->price) / 1000, 2);
//
//                if ($user->balance < $price) {
//                    return response()->json(['errors' => ['message' => "Insufficient balance."]], 422);
//                }
//
//                $order = new Order();
//                $order->user_id = $user->id;
//                $order->category_id = $service->category_id;
//                $order->service_id = $service->id;
//                $order->link = $req['link'];
//                $order->quantity = $req['quantity'];
//                $order->status = 'processing';
//                $order->price = $price;
//                $order->runs = isset($req['runs']) ? $req['runs'] : null;
//                $order->interval = isset($req['interval']) ? $req['interval'] : null;
//                if (isset($service->api_provider_id)) {
//                    $apiproviderdata = ApiProvider::find($service->api_provider_id);
//                    $postData = [
//                        'key' => $apiproviderdata['api_key'],
//                        'action' => 'add',
//                        'service' => $service->api_service_id,
//                        'link' => $req['link'],
//                        'quantity' => $req['quantity']
//                    ];
//                    if (isset($req['runs']))
//                        $postData['runs'] = $req['runs'];
//
//                    if (isset($req['interval']))
//                        $postData['interval'] = $req['interval'];
//
//                    $apiservicedata = Curl::to($apiproviderdata['url'])->withData($postData)->post();
//                    $apidata = json_decode($apiservicedata);
//                    if (isset($apidata->order)) {
//                        $order->status_description = "order: {$apidata->order}";
//                        $order->api_order_id = $apidata->order;
//                    } else {
//                        $order->status_description = "error: {$apidata->error}";
//                    }
//                }
//                $order->save();
//
//                $user->balance -= $price;
//                $user->save();
//
//                $transaction = new Transaction();
//                $transaction->user_id = $user->id;
//                $transaction->trx_type = '-';
//                $transaction->amount = $price;
//                $transaction->remarks = 'Place order';
//                $transaction->trx_id = strRandom();
//                $transaction->charge = 0;
//                $transaction->save();
//
//                $this->sendMailSms($user, 'ORDER_CONFIRM', [
//                    'order_id' => $order->id,
//                    'order_at' => $order->created_at,
//                    'service' => optional($order->service)->service_title,
//                    'status' => $order->status,
//                    'paid_amount' => $price,
//                    'remaining_balance' => $user->balance,
//                    'currency' => $basic->currency,
//                    'transaction' => $transaction->trx_id,
//                ]);
//
//                $result['status'] = 'success';
//                $result['order'] = $order->id;
//                return response()->json($result, 200);
//
//            } else {
//                return response()->json(['errors' => ['message' => "Order quantity should be minimum {$service->min_amount} and maximum {$service->max_amount}"]], 422);
//            }

        } elseif (strtolower($req['action']) == 'status') {

            $validator = Validator::make($req, [
                'order' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::where('id', $req['order'])->where('user_id', $user->id)->first();
            if (!$order) {
                return response()->json(['errors' => ['message' => "Invalid Order"]], 422);
            }

            $result['status'] = $order->status;
            $result['charge'] = $order->service['api_provider_price'];
            $result['start_count'] = (int)$order->start_count;
            $result['code'] = $order->code;
            $result['currency'] = $basic->currency;
            $result['description'] = $order->status_description;
            return response()->json($result, 200);
        } elseif (strtolower($req['action']) == 'orders') {
            $validator = Validator::make($req, [
                'orders' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $orders = explode(",", $req['orders']);

            $result = Order::whereIn('id', $orders)->where('user_id', $user->id)->get()->map(function ($order) {
                return [
                    'order' => $order->id,
                    'status' => $order->status,
                    'charge' => $order->service['api_provider_price'],
                    'start_count' => (int)$order->start_count,
                    'code' => $order->code,
                    'description' => $order->status_description
                ];
            });
            return response()->json($result, 200);

        } elseif (strtolower($req['action']) == 'smscode') {
            $validator = Validator::make($req, [
                'order' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $order = Order::where('id', $req['order'])->where('user_id', $user->id)->first();
            if (isset($order->code)) {
                return response()->json(['status' => 'success', 'smsCode' => $order->code], 200);
            } else {
                $provider = $order->service->provider;
                $response = app()->make($provider->slug)->setProvider(mapProvider($provider))->getSMS($order->api_order_id);
                if (isset($response['status']) && $response['status'] != $order->status) {
                    if (isset($response['code'])) {
                        DB::beginTransaction();
                        try {
                            $order->code = $response['code'];
                            $order->status = 'completed';
                            $order->save();
                            $this->finishNumberOrder($order);
                            DB::commit();
                            return response()->json(['status' => 'success', 'smsCode' => $response['code']], 200);
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                    } else {
                        changeOrderStatusService::statusChange($order, $response['status']);
                        return response()->json(['status' => 'error', 'message' => 'NO_ACTIVATIONS please try agin later'], 200);
                    }
                }
            }
        }
    }

    public function finishNumberOrder($order)
    {
        $user = $order->users;
        $user->balance -= $order->price;
        $user->save();
        $transaction = new TransactionService();
        $transaction->createTransaction($user, $order->price, 'Place order ' . $order->id, '-');
    }

}
