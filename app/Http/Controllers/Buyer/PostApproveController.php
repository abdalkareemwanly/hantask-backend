<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\PostApprov;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApproveController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = PostApprov::whereHas('buyer')->whereHas('post')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
                    'post image'         => '/uploads/images/posts/'.$row->post->image,
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
            $paginate = PostApprov::whereHas('buyer')->whereHas('post')
                ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
                    'post image'         => '/uploads/images/posts/'.$row->post->image,
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
            $paginate = PostApprov::whereHas('buyer')->whereHas('post')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
                    'post image'         => '/uploads/images/posts/'.$row->post->image,
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
    public function reports($id)
    {
        $data = [];
        $reports = Report::whereHas('postApprove')->whereHas('seller')->whereRelation('postApprove','id',$id)->first();
        $data [] = [
            'report id' => $reports->id,
            'postApprove id' => $reports->postApprove->id,
            'report' => $reports->report,
            'seller name' => $reports->seller->name,
            'seller email' => $reports->seller->email,
            'seller phone' => $reports->seller->phone,
        ];
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
    public function storeReport(Request $request , $id)
    {
        $request->validate([
            'report' => 'required|string'
        ]);
        $report = $request->report;
        $postApprove = PostApprov::whereHas('comment')->where('id',$id)->first();
        $repost = Report::where('postApprove_id',$id)->first();
        if(!$repost) {
            Report::create([
                'postApprove_id'   => $id,
                'seller_id'        => $postApprove->comment->seller_id,
                'buyer_id'         => Auth::user()->id,
                'report'           => $report
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Approved Report Successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mes' => 'Approved Report Alread Exsits',
            ]);
        }
    }
}
