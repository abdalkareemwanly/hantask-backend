<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class NotificationController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tableName = 'notifications';
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $postRef = $this->database->getReference($this->tableName)->push($data);
        if($postRef) {
            Notification::create($data);
            return response()->json([
                'success' => true,
                'mes' => 'Store Notification Successfully',
            ]);
        }
    }
}
