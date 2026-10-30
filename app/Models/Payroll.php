<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payroll extends Model {
    use SoftDeletes;
    protected $fillable = ["user_id","month","basic_salary","allowances","deductions","net_salary","status","payment_date"];
    protected $casts = ["payment_date" => "date"];
    public function user() { return $this->belongsTo(User::class); }
    
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