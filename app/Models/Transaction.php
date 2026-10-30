<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transaction extends Model {
    use SoftDeletes;
    protected $fillable = ["reference","account_id","vendor_id","type","amount","occurred_at","description"];
    protected $casts = ["occurred_at" => "date"];
    public function account() { return $this->belongsTo(Account::class); }
    public function vendor() { return $this->belongsTo(Vendor::class); }
    
    protected static function booted()
    {
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