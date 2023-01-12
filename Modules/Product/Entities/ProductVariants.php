<?php

namespace Modules\Product\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariants extends BaseModel
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = [
        'parent_id', 'name', 'description', 'price', 'discount_price', 'picture', 'offer', 'discount_percentage', 'featured', 'size'
    ];
}
