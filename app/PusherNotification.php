<?php

namespace App;

use App\Notifications\TlgNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;


class PusherNotification extends Model
{
    //
    public static function send($notifier ,$type,$data=[])
    {
        $options = array(
            'cluster' => ENV('PUSHER_APP_CLUSTER'),
            'encrypted' => ENV('PUSHER_ENCRYPTED') //dont forget to turn it true in server
        );

        $pusher = new Pusher(
            ENV('PUSHER_APP_KEY'),
            ENV('PUSHER_APP_SECRET'),
            ENV('PUSHER_APP_ID'),
            $options
        );



        $pusher->trigger($notifier, $type, $data);

    }
    public static function sendAll($notifiers,$title, $message, $link)
    {
        if ($notifiers->count() > 0) {

            foreach ($notifiers->chunk(100) as $chunk) {
                Notification::send($chunk, new TlgNotification($title, $message, $link));
                foreach ($chunk as $notifier) {
                    self::send("$notifier->id", 'notification', [
                        'title' => $title,
                        'message' => $message,
                        'link' => $link,
                    ]);
                }
            }
        }

    }


}
