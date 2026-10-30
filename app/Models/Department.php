<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Department extends Model {
    use SoftDeletes;
    protected $fillable = ["name","code","description"];
    public function employees() { return $this->hasMany(Employee::class); }
    
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