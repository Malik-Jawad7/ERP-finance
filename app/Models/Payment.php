<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model {
    use SoftDeletes;
    protected $fillable = ["user_id", "invoice_id", "receipt_no", "amount", "method", "reference", "paid_at", "notes"];
    protected $casts = ["paid_at" => "date"];
    
    public function invoice() { return $this->belongsTo(Invoice::class); }

    protected static function booted() {
        static::addGlobalScope('user', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
        static::creating(function ($model) {
            if (auth()->check() && empty($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    }
}