<?php

namespace Modules\Invoices\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends BaseModel
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'domain_id', 'parent_id', 'name', 'description', 'cat_id', 'picture', 'featured', 'offer', 'offer_type', 'on_purchase', 'free_qty'
    ];
}
