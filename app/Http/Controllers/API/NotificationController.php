<?php

namespace App\Http\Controllers\API;

use App\Events\FirebasePushNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreRequest;
use App\Models\Admin;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Database;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\CloudMessagingClient;

use Pusher\Pusher;

class NotificationController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(Notification::all() as $notify) {
            $data [] = [
                'id'      => $notify->id,
                'title'   => $notify->title,
                'read_at' => $notify->read_at,
            ];
        }
        return response()->json([
            'success' => true,
            'mes' => 'All Notification',
            'data' => $data,
        ]);
    }
    public function store(StoreRequest $request)
    {
        try
        {
            $req = $request->validated();
            $data = [
                'userName' => Auth::user()->name,
                'title' => $request->title
            ];
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_APP_CLUSTER')]
                );
            $pusher->trigger('hantask', 'pushNotificationEvent', $data,['persisted' => true]);
            Notification::create($req);
            return response()->json([
                'success' => true,
                'message' => 'Notification stored successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
