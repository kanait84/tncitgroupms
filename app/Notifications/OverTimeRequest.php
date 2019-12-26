<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OverTimeRequest extends Notification
{
    use Queueable;
    public $message;
    public $username;
    public $reportdate;
    public $u_id;
    public $mgr_id;
    public $report_uid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username, $reportdate, $u_id, $mgr_id, $report_uid)
    {
        //
        $this->username = $username;
        $this->reportdate = $reportdate;
        $this->u_id = $u_id;
        $this->mgr_id = $mgr_id;
        $this->report_uid = $report_uid;
        $this->message  = "{$username} requested OverTime of the date - ".$reportdate;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => "{$this->username} requested OverTime of the date - ".$this->reportdate,
            'u_id' => $this->u_id,
            'mgr_id' => $this->mgr_id,
            'report_uid' => $this->report_uid,
            'reportdate' => $this->reportdate
        ];
    }
}
