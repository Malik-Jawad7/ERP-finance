<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model {
    protected $fillable = ["user_id", "title", "message", "icon", "is_read"];
    
    protected static function booted() {
        static::creating(function ($model) {
            if (auth()->check() && empty($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    }
}