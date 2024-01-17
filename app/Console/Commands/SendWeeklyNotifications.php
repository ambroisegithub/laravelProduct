<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationController;

class SendWeeklyNotifications extends Command
{
    protected $signature = 'app:send-weekly-notifications';
    protected $description = 'Send pregnancy notifications to users';

    public function handle()
    {
        $notificationController = new NotificationController();
        $notificationController->sendNotifications();
        $this->info('Notifications sent successfully.');
    }
}
