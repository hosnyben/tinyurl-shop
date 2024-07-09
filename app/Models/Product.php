<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    // For optimisation purpose, we won't be using Laravel SofDeletes. as it creates date column instead of bool

    protected $primaryKey = 'uuid';

    protected $hidden = ['id','top','deleted','created_at','updated_at'];

    protected $fillable = ['name', 'description', 'price', 'top'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $columns = array_column($builder->getQuery()->wheres, 'column');

            if(!in_array('deleted', $columns)) {
                $builder->where('products.deleted', 0);
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function delete()
    {
        $this->deleted = true;
        $this->save();
    }
}
