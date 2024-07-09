<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use HasUuids;
    // For optimisation purpose, we won't be using Laravel SofDeletes. as it creates date column instead of bool

    protected $primaryKey = 'uuid';
}
