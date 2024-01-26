<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Report::whereHas('comment')
                    ->where('report','like', '%' . $request->search . '%')
                    ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'buyer name' =>  $row->comment->post->buyer->name,
                    'buyer email' => $row->comment->post->buyer->email,
                    'buyer phone' => $row->comment->post->buyer->phone,
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
            $paginate = Report::whereHas('comment')
                ->where('report','like', '%' . $request->search . '%')
                ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'buyer name' =>  $row->comment->post->buyer->name,
                    'buyer email' => $row->comment->post->buyer->email,
                    'buyer phone' => $row->comment->post->buyer->phone,
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
            $paginate = Report::whereHas('comment')
                ->where('report','like', '%' . $request->search . '%')
                ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'buyer name' =>  $row->comment->post->buyer->name,
                    'buyer email' => $row->comment->post->buyer->email,
                    'buyer phone' => $row->comment->post->buyer->phone,
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
    public function store(Request $request)
    {
        $request->validate([
            'report'       => 'required|string',
            'comment_id'   => 'required'
        ]);
        $buyer_id = Comment::whereHas('post')->where('id',$request->comment_id)->first();
        Report::create([
            'sender_id'      => Auth::user()->id,
            'recipient_id'   => $buyer_id->post->buyer_id,
            'comment_id'     => $request->comment_id,
            'report'         => $request->report
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Store Report Successfully',
        ]);
    }
    public function update(Request $request , $id)
    {
        $request->validate([
            'report'       => 'nullable|string',
            'comment_id'   => 'nullable',
            'recipient_id' => 'nullable',
        ]);
        $buyer_id = Comment::whereHas('post')->where('id',$request->comment_id)->first();
        $record = Report::find($id);
        $record->update([
            'comment_id'    => $request->comment_id ?? $record->comment_id,
            'recipient_id'  => $buyer_id->post->buyer_id ?? $record->recipient_id,
            'report'        => $request->report ?? $record->report,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Report Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Report::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Report Successfully',
        ]);
    }
}
