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
            $paginate = Report::whereHas('postApprove')->whereHas('seller')
                    ->where('report','like', '%' . $request->search . '%')
                    ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'postApprove id' => $row->postApprove->id,
                    'report' => $row->report,
                    'seller name' => $row->seller->name,
                    'seller email' => $row->seller->email,
                    'seller phone' => $row->seller->phone,
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
            $paginate = Report::whereHas('postApprove')->whereHas('seller')
                    ->where('report','like', '%' . $request->search . '%')
                    ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'postApprove id' => $row->postApprove->id,
                    'report' => $row->report,
                    'seller name' => $row->seller->name,
                    'seller email' => $row->seller->email,
                    'seller phone' => $row->seller->phone,
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
            $paginate = Report::whereHas('postApprove')->whereHas('seller')->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'postApprove id' => $row->postApprove->id,
                    'report' => $row->report,
                    'seller name' => $row->seller->name,
                    'seller email' => $row->seller->email,
                    'seller phone' => $row->seller->phone,
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
            'postApprove_id' => 'required',
        ]);
        $seller = PostApprov::whereHas('comment')->where('id',$request->postApprove_id)->first();
        Report::create([
            'postApprove_id' => $request->postApprove_id,
            'seller_id'      => $seller->comment->seller_id,
            'buyer_id'       => Auth::user()->id,
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
            'report'         => 'required|string',
            'postApprove_id' => 'required',
        ]);
        $seller = PostApprov::whereHas('comment')->where('id',$request->postApprove_id)->first();
        $record = Report::find($id);
        $record->update([
            'postApprove_id'  => $request->postApprove_id ?? $record->postApprove_id,
            'seller_id'       => $seller->comment->seller_id ?? $record->seller_id,
            'report'          => $request->report ?? $record->report,
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
