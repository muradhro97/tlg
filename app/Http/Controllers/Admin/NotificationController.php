<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //

    public function index()
    {
        $user = auth()->user();
        $rows = $user->notifications()->paginate(20);
        return view('admin.notification.index', compact('rows'));
    }
    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications->take(3);
        $notification_count = $user->unreadNotifications->count();
//        $notifications = $user->notifications;
        $html = view('admin.notification.notifications', compact('notifications','notification_count'))->render();
        $response = [
            'status' => true,
            'html' => $html,
// 'msg' => 'من فضلك أدخل جميع الحقول وتأكد من صحة رقم الهاتف',
        ];
        return response()->json($response, 200);
//        return view('admin.notification.notifications', compact('rows'));
    }

    public function readNotifications(){
        $user = auth()->user();
        $notifications = $user->notifications()->where('read_at',null)->get();
        foreach ($notifications as $notification){
            $notification->update([
                'read_at'   =>  now()
            ]);
        }
        return redirect()->back();
    }
}
