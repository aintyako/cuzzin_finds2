<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Cuzzin Finds Order Receipt')
            ->view('emails.order-receipt')
            ->with([
                'order' => $this->order,
                'items' => json_decode($this->order->items_json, true) ?? [],
            ]);
    }
}
