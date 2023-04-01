<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function createTransaction($user,$price,$remark,$type,$charge=0)
    {
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx_type = '-';
        $transaction->amount = $price;
        $transaction->remarks = $remark;
        $transaction->trx_id = strRandom();
        $transaction->charge = $charge;
        $transaction->save();
        return $transaction;
    }
}
