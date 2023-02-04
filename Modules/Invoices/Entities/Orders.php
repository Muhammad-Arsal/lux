<?php

namespace Modules\Invoices\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends BaseModel
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'orders';

    // protected $fillable = [
    //     'member_id', 'time', 'order_type', 'bill', 'total', 'status', 'paid'
    // ];
}
