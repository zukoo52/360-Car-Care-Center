<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SystemNotifications;
use App\Models\UserNotifications;
use Illuminate\Http\Request;

class ApiNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:other_systemNotifications')->only([
            'getSystemNotifications',
            'markAsReadSystemNotification',
            'deleteSystemNotification'
        ]);
    }

    public function getUserNotifications(Request $request)
    {
        $notifications = auth('sanctum')->user()->notifications();

        if ($keyword = $request->get('keyword')) {
            $notifications->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
        }

        $notifications->orderBy('created_at', 'desc');

        if ($limit = $request->get('limit')) {
            return response()->json($notifications->paginate($limit), 200);
        }
        return response()->json($notifications->get(), 200);
    }

    public function markAsReadUserNotification($id)
    {
        $notification = UserNotifications::find($id);
        if(is_null($notification)) return response()->json(['message' => 'Operation failed, No record found!'], 404);

        $notification->has_read = true;
        $notification->save();

        return response()->json(['message' => 'Record updated successfully!'], 200);
    }

    public function deleteUserNotification($id)
    {
        $notification = UserNotifications::find($id);
        if(is_null($notification)) return response()->json(['message' => 'No record found!'], 404);

        $notification->delete();
        if(!$notification) return response()->json(['message' => 'Failed to delete the notification, please try again!'], 500);
        return response()->json(['message' => 'Notification deleted successfully!'], 200);
    }

    public function getSystemNotifications(Request $request)
    {
        $notifications = SystemNotifications::query();

        if ($keyword = $request->get('keyword')) {
            $notifications->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
        }

        $notifications->orderBy('created_at', 'desc');

        if ($limit = $request->get('limit')) {
            return response()->json($notifications->paginate($limit), 200);
        }
        return response()->json($notifications->get(), 200);
    }

    public function markAsReadSystemNotification($id)
    {
        $notification = SystemNotifications::find($id);
        if(is_null($notification)) return response()->json(['message' => 'Operation failed, No record found!'], 404);

        $notification->has_read = true;
        $notification->save();

        return response()->json(['message' => 'Record updated successfully!'], 200);
    }

    public function deleteSystemNotification($id)
    {
        $notification = SystemNotifications::find($id);
        if(is_null($notification)) return response()->json(['message' => 'No record found!'], 404);

        $notification->delete();
        if(!$notification) return response()->json(['message' => 'Failed to delete the notification, please try again!'], 500);
        return response()->json(['message' => 'Notification deleted successfully!'], 200);
    }
}
