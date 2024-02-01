<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Review\Message\StoreRequest;
use App\Http\Requests\Buyer\Review\Message\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Report;
use App\Models\ReportMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Report::where('report','like', '%' . $request->search . '%')
                    ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $user = User::where('id',$row->sender_id)->orWhere('id',$row->recipient_id)->first();
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
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
            $paginate =  $paginate = Report::where('report','like', '%' . $request->search . '%')
                ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $user = User::where('id',$row->sender_id)->orWhere('id',$row->recipient_id)->first();
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
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
            $paginate =  $paginate = Report::where('report','like', '%' . $request->search . '%')
                ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $user = User::where('id',$row->sender_id)->orWhere('id',$row->recipient_id)->first();
                $report_from = [];
                $report_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $report_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $report_from = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $report_to = [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
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
    public function message($id)
    {
        $data = [];
        $reprot_messages = ReportMessage::whereHas('report')
            ->whereRelation('report','report_id',$id)
            ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->get();
        $report_message_from = [];
        $report_message_to = [];
        foreach($reprot_messages as $row)
        {
            $user = User::where('id',$row->sender_id)->orWhere('id',$row->recipient_id)->first();
            if($row->sender_id == Auth::user()->id) {
                $report_message_to[] = [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ];
                $report_message_from[] = [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ];
            } elseif($row->recipient_id == Auth::user()->id) {
                $report_message_to[] = [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ];
                $report_message_from[] = [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ];
            }
            $data[] = [
                'id'                  => $row->id,
                'message'             => $row->message,
                'file'                => '/uploads/images/reports/images/'.$row->file,
                'report_id'           => $row->report->id,
                'report_message_to'   => $report_message_to,
                'report_message_from' => $report_message_from,
            ];
        }
        return response()->json([
            'success' => true,
            'mes'     => 'success',
            'data'    => $data
        ]);
    }
    public function storeMessage(StoreRequest $request , $id)
    {
        $report = Report::where('id',$id)->first();
        $data = $request->validated();
        $data['sender_id'] = Auth::user()->id;
        $data['report_id'] = $id;
        $data['recipient_id'] = $report->sender_id;
        $data['file'] = $this->saveImage($request->file('file'),'uploads/images/reports/images');
        ReportMessage::create($data);
        return response()->json([
            'success' => true,
            'mes'     => 'Store ReportMessage Successfully'
        ]);
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

}
