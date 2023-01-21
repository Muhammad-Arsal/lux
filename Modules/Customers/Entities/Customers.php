<?php

namespace Modules\Customers\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends BaseModel
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'customers';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'fax', 'city', 'address', 'company', 'state', 'zip',
    ];
}
