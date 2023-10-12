<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order ;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
//        $channels =['database'];
//        if ($notifiable->method['order_created']['mail'] ?? false){
//            $channels[] ='vonage';
//            return $channels;
//        };
        return ['mail' , 'database' ,'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddreses;
        return (new MailMessage)
                    ->subject('New Order #' . $this->order->number)
                    ->greeting("Hi {$notifiable->name},")
                    ->line("A New Order (#{$this->order->number}) created by {$addr->full_name} from {$addr->country_name}.")
                    ->action('View Order', url('/dashboard')) //button
                    ->line('Thank you for using our application!');
    }



    public function toDatabase($notifiable){
        $addr = $this->order->billingAddreses;

        return[
            'message' => "A New Order (#{$this->order->number}) created by {$addr->full_name} from {$addr->country_name}.",
            'icon'    => 'fas fa-file',
            'url'     => '/dashboard',
            'order_id' => $this->order->id
        ];
    }

    public function toBroadcast($notifiable){
        $addr = $this->order->billingAddreses;

        return new BroadcastMessage([
            'message' => "A New Order (#{$this->order->number}) created by {$addr->full_name} from {$addr->country_name}.",
            'icon'    => 'fas fa-file',
            'url'     => '/dashboard',
            'order_id' => $this->order->id
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
