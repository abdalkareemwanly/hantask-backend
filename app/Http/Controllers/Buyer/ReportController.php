<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use App\Models\PostApprov;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Report::whereHas('comment')->whereHas('buyer')
                    ->where('report','like', '%' . $request->search . '%')
                    ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'seller name' => $row->comment->seller->name,
                    'seller email' => $row->comment->seller->email,
                    'seller phone' => $row->comment->seller->phone,
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
            $paginate = Report::whereHas('comment')->whereHas('buyer')
                ->where('report','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'seller name' => $row->comment->seller->name,
                    'seller email' => $row->comment->seller->email,
                    'seller phone' => $row->comment->seller->phone,
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
            $paginate = Report::whereHas('comment')->whereHas('buyer')
                ->where('report','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'report' => $row->report,
                    'seller name' => $row->comment->seller->name,
                    'seller email' => $row->comment->seller->email,
                    'seller phone' => $row->comment->seller->phone,
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
            'report'         => 'required|string',
            'comment_id' => 'required',
        ]);
        Report::create([
            'buyer_id'       => Auth::user()->id,
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
            'report'     => 'required|string',
            'comment_id' => 'required',
        ]);
        $record = Report::find($id);
        $record->update([
            'comment_id'  => $request->comment_id ?? $record->comment_id,
            'report'      => $request->report ?? $record->report,
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
