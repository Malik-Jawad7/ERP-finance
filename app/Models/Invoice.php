<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = ["invoice_no","client_id","amount","tax","total","status","issued_at","due_at"];
    protected $casts = ["issued_at" => "date", "due_at" => "date"];
    public function client() { return $this->belongsTo(Client::class); }
    
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