<?php
namespace App\Http\Controllers;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller {
    public function markAsRead() {
        CustomNotification::where("user_id", auth()->id())->where("is_read", false)->update(["is_read" => true]);
        return response()->json(["success" => true]);
    }
    
    public function clearAll() {
        CustomNotification::where("user_id", auth()->id())->delete();
        return response()->json(["success" => true]);
    }
}