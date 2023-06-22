<?php

namespace App\Console\Commands;

use App\Models\ApiProvider;
use App\Models\Order;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Console\Command;
use Symfony\Polyfill\Intl\Idn\Info;
use Zkood\DeliveryPortal\Models\Log;

class Cron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cron:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for Order Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Order::with(['service', 'service.provider'])->whereNotIn('status', ['completed', 'refunded', 'canceled'])->whereHas('service', function ($query) {
            $query->whereNotNull('api_provider_id')->orWhere('api_provider_id', '!=', 0);
        })->get()->map(function ($order) {
            $service = $order->service;
            if (isset($service->api_provider_id)) {
                $apiproviderdata = $service->provider;
                if ($service->api_provider_id != 3 && 0 == 1) {
                    $apiservicedata = Curl::to($apiproviderdata['url'])->withData(['key' => $apiproviderdata['api_key'], 'action' => 'status', 'order' => $order->api_order_id])->post();
                    $apidata = json_decode($apiservicedata);
                    if (isset($apidata->order)) {
                        $order->status_description = "order: {$apidata->order}";
                        $order->api_order_id = $apidata->order;
                    } else {
                        $order->status_description = "error: {@$apidata->error}";
                    }
                }
//                else {
//                    $postData = [
//                        'api_key' => $apiproviderdata['api_key'],
//                        'action' => 'getActiveActivations'
//                    ];
//                    $apiservicedata = Curl::to($apiproviderdata['url'])->withData($postData)->post();
//                    $apidata = json_decode($apiservicedata, 1);
//                    if (isset($apidata['status']) && $apidata['status'] == "success") {
//                        foreach ($apidata['activeActivations'] as $activation) {
//                            if ($activation['activationId'] == $order->api_order_id) {
//                                $this->info($activation);
//                                if (isset($activation['smsCode'][0])) {
//                                    if ($order->status != 'completed') {
//                                        $order->status_description = "smscode: {$activation['smsCode'][0]}";
//                                        $order->status = 'completed';
//                                        $order->save();
//                                        app('App\Http\Controllers\ApiController')->finishNumberOrder($order);
//                                    }
//                                }
//                            }
//                        }
//                    }
//
//                }
                $order->save();
            }
        });
        $this->info('status');
        $numberOrders = Order::with(['service', 'service.provider'])->whereNotIn('status', ['completed', 'refunded', 'canceled'])->whereHas('service', function ($query) {
            $query->whereNotNull('api_provider_id')->orWhere('api_provider_id', '=', 2);
        })->get();
        $apiproviderdata = ApiProvider::findorfail(2);
        foreach ($numberOrders as $order) {
            $postData = [
                'api_key' => $apiproviderdata['api_key'],
                'action' => 'getStatus',
                'id' => $order->api_order_id
            ];
            $apiservicedata = Curl::to($apiproviderdata['url'])->withData($postData)->post();
            if ($apiservicedata == 'STATUS_CANCEL' || $apiservicedata == 'WRONG_ACTIVATION_ID') {
                $order->status = 'canceled';
                $order->save();
            } elseif ($apiservicedata == 'STATUS_OK')
                $this->finishNumberOrder($order, $apiproviderdata);
            $this->info($order->status);
        }
    }

    public function finishNumberOrder($order, $apiProvider)
    {
        $postData = [
            'api_key' => $apiProvider['api_key'],
            'action' => 'getActiveActivations'
        ];
        $apiservicedata = Curl::to($apiProvider['url'])->withData($postData)->post();
        $apidata = json_decode($apiservicedata, 1);
        if (isset($apidata['status']) && $apidata['status'] == "success") {
            foreach ($apidata['activeActivations'] as $activation) {
                if ($activation['activationId'] == $order->api_order_id) {
                    $this->info($activation);
                    if (isset($activation['smsCode'][0])) {
                        if ($order->status != 'completed') {
                            $order->status_description = "smscode: {$activation['smsCode'][0]}";
                            $order->status = 'completed';
                            $order->save();
                            app('App\Http\Controllers\ApiController')->finishNumberOrder($order);
                        }
                    }
                }
            }
        }
    }
}
