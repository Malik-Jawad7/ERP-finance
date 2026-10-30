<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model {
    use SoftDeletes;
    protected $fillable = ["name","client_id","budget","status","start_date","end_date"];
    protected $casts = ["start_date" => "date", "end_date" => "date"];
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