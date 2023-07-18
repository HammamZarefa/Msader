<?php

namespace App\Exceptions;

use App\Models\Admin;
use App\Notifications\ExceptionNotificationTelegram;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $admins = Admin::all();
            foreach ($admins as $admin){
               $admin->notify(new ExceptionNotificationTelegram($e->getMessage(),$e->getLine(),$e->getFile()));
            }
        });
    }

    
}
