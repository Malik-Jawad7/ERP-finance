<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    protected $fillable = ["title","category","amount","spent_at","notes"];
    protected $casts = ["spent_at" => "date"];
    
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