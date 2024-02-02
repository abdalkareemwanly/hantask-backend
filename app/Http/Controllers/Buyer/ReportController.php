<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Review\Message\StoreRequest;
use App\Http\Requests\Buyer\Review\Message\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Report;
use App\Models\ReportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Report::whereHas('comment')
                    ->where('report','like', '%' . $request->search . '%')
                    ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                    $report_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];

                }
                
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'report_to' => $report_to,
                    'report_from' => $report_from
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
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                    $report_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];

                }
                
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'report_to' => $report_to,
                    'report_from' => $report_from
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
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $row->comment->seller->name,
                        'email' => $row->comment->seller->email,
                        'phone' => $row->comment->seller->phone,
                    ];
                    $report_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];

                }
                
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'report_to' => $report_to,
                    'report_from' => $report_from
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
            'recipient_id' => 'required',
        ]);
        $comment = Comment::where('seller_id',$request->recipient_id)->first();
        Report::create([
            'sender_id'      => Auth::user()->id,
            'recipient_id'   => $request->recipient_id,
            'comment_id'     => $comment->id,
            'report'         => $request->report
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Store Report Successfully',
        ]);
    }
    public function message($id)
    {
        $data = [];
        $reprot = Report::find($id);
        $reprot_messages = ReportMessage::whereHas('report')
            ->whereRelation('report','report_id',$id)
            ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->get();
        
        foreach($reprot_messages as $row)
        {
          if($row->report_id == $id)
          {
        
            $admin = Admin::where('id',$row->sender_id)->first();
          
              $data[] = [
                  'sender_id'   => $admin ? $admin->id : Auth::user()->id,
                  'sender_name' => $admin ? $admin->name : Auth::user()->name,
                  'sender_email' => $admin ? $admin->email : Auth::user()->email,
                  'id' => $row->id,
                  'message'   => $row->message,
                  'file'     => '/uploads/images/reports/images/' . $row->file
             ];
          }
        }
         return response()->json([
              'success' => true,
              'mes'     => 'success',
              'data'    => $data
          ]);
     }
    public function storeMessage(StoreRequest $request , $id)
    {
        $admin = Admin::where('accepted_report','1')->first();
        $data = $request->validated();
        $data['sender_id'] = Auth::user()->id;
        $data['report_id'] = $id;
        $data['recipient_id'] = $admin->id;
        if($data['file']) {
            $data['file'] = $this->saveImage($request->file('file'),'uploads/images/reports/images');
            ReportMessage::create($data);
            return response()->json([
                'success' => true,
                'mes'     => 'Store ReportMessage Successfully'
            ]);
        } else {
            ReportMessage::create($data);
            return response()->json([
                'success' => true,
                'mes'     => 'Store ReportMessage Successfully'
            ]);
        }
    }
    public function updateMessage(UpdateRequest $request , $id)
    {
        $record = ReportMessage::find($id);
        if(request()->hasFile('file')) {
            File::delete('uploads/images/reports/images/'.$record->image);
        }
        if(isset($request->file)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/reports/images');
        }
        $record->update([
            'message' => $request->message ?? $record->message,
            'file'    => $data['file'] ?? $record->file,
        ]);
        return response()->json([
            'success' => true,
            'mes'     => 'Update ReportMessage Successfully'
        ]);
    }
    public function deleteMessage($id)
    {
        $post = ReportMessage::find($id);
        $path = 'uploads/images/reports/images/'.$post->image;
        if(File::exists($path)) {
            File::delete('uploads/images/reports/images/'.$post->image);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete ReportMessage Successfully',
        ]);
    }
    public function update(Request $request , $id)
    {
        $request->validate([
            'report'       => 'nullable|string',
            'comment_id'   => 'nullable',
            'recipient_id' => 'nullable',
        ]);
        $comment = Comment::where('seller_id',$request->recipient_id)->first();
        $record = Report::find($id);
        $record->update([
            'comment_id'    => $comment->id ?? $record->comment_id,
            'recipient_id'  => $request->recipient_id ?? $record->recipient_id,
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