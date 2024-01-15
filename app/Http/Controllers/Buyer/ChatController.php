<?php

namespace App\Http\Controllers\Buyer;

use App\Events\PusherChatEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ChatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use imageTrait;
    public function getContact()
    {
        $data = [];
        foreach(Chat::whereHas('user')->where('recipient_id','!=',Auth::user()->id)->get() as $chat) {
            $data[] = [
                'userName' => $chat->user->name
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'All Contact',
            'data' => $data,
        ]);
    }
    public function getMessage($id)
    {
        $data = [];
        foreach(Chat::where('user_id',Auth::user()->id)->where('recipient_id',$id)->get() as $chat) {
            $data[] = [
                'message' => $chat->message
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'All Messages',
            'data' => $data,
        ]);
    }
    public function storeMessage(ChatRequest $request , Chat $chatMessage)
    {
        $data = $request->validated();
        $user = auth()->user();
        $message = $request->message;
        $data['user_id'] = $user->id;

        if ($request->hasFile('file')) {
            $data['file'] = $this->saveImage($request->file,'uploads/images/chats');
        }
        broadcast(new PusherChatEvent($chatMessage))->toOthers();

        Chat::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Store Message Successfully',
        ]);
    }
}
