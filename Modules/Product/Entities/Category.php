<?php

namespace Modules\Product\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'domain_id', 'name', 'parent_id'
    ];
}
