<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;

class changeOrderStatusService
{
    public static function statusChange(Order $order, $status)
    {
        $user = $order->users;
        if ($status == 'refunded') {
            if ($order->status != 'refunded') {
                $user->balance += $order->price;
                $transaction1 = new Transaction();
                $transaction1->user_id = $user->id;
                $transaction1->trx_type = '+';
                $transaction1->amount = $order->price;
                $transaction1->remarks = 'استرجاع الرصيد بعد تحويل حالة الطلب الى مسترجع';
                $transaction1->trx_id = strRandom();
                $transaction1->charge = 0;
                if ($user->save()) {
                    $transaction1->save();
                }
            }
        }
        $order->status = strtolower($status);
        $order->save();
    }
}
