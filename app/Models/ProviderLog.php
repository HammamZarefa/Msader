<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderLog extends Model
{
    // protected $casts = [
    //     'header' => 'json',
    //     'body' => 'json',
    //     'disclosure' => 'json',
    // ];


    protected $fillable = ['order_id', 'url', 'method', 'header', 'body', 'disclosure'];
}
