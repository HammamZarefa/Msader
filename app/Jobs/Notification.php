<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\SiteNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class Notification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = Admin::all();
        foreach ($admins as $admin){
            $siteNotification = new SiteNotification();
            $siteNotification->description = $this->action;
            $admin->siteNotificational()->save($siteNotification);

           $admin->notify(new TelegramNotification($siteNotification->description));
            event(new \App\Events\AdminNotification($siteNotification, $admin->id));
        }
    }
}
