<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\NotificationSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = NotificationSeller::whereHas('seller')
                ->where('title','like', '%' . $request->search . '%')
                ->where('seller_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'     => $row->id,
                    'title'  => $row->title,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }
        if($request->paginate) {
            $paginate = NotificationSeller::whereHas('seller')
                ->where('title','like', '%' . $request->search . '%')
                ->where('seller_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'     => $row->id,
                    'title'  => $row->title,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        } else {
            $paginate = NotificationSeller::whereHas('seller')
                ->where('title','like', '%' . $request->search . '%')
                ->where('seller_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'     => $row->id,
                    'title'  => $row->title,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }
    }
    public function pusher(Request $request)
    {
        $user = $request->user();
        $notifications = NotificationSeller::whereNull('notifiable_type')
            ->orWhere('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->app['events']->listen('pusher:notification_sellers', function ($notification) use ($user) {
            if ($notification['user_id'] == $user->id) {
                $user->notification_sellers()->create($notification);
            }
        });
        return response()->json($notifications);
    }
}
