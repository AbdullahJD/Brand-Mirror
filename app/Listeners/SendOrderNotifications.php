<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        // 🔥 هنا لاحقًا Email / WhatsApp
        Log::info("New Order Created: " . $order->order_number);

        // مثال:
        // Mail::to($order->email)->send(...)
        // Notification::send(...)
    }
}
