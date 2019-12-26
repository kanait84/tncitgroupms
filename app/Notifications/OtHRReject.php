<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OtHRReject extends Notification
{
    use Queueable;
    public $username;
    public $reportdate;
    public $u_id;
    public $r_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username, $reportdate, $u_id, $r_id)
    {
        $this->username = $username;
        $this->reportdate = $reportdate;
        $this->u_id = $u_id;
        $this->r_id = $r_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => "{$this->username} rejected your report of the date - ".$this->reportdate,
            'u_id' => $this->u_id,
            'r_id' => $this->r_id,
            'reportdate' => $this->reportdate
        ];
    }
}
