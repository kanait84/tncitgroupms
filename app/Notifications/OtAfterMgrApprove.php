<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OtAfterMgrApprove extends Notification
{
    use Queueable;
    public $username;
    public $u_id;
    public $ot_date;
    public $report_uid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username, $u_id, $report_uid, $ot_date)
    {
        $this->username = $username;
        $this->u_id = $u_id;
        $this->ot_date = $ot_date;
        $this->report_uid = $report_uid;
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
            'data' => "{$this->username} requested OverTime of the date - ".$this->ot_date,
            'u_id' => $this->u_id,
            'report_uid' => $this->report_uid,
            'otdate' => $this->ot_date
        ];
    }
}
