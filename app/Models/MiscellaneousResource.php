<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousResource extends Model
{
    protected $table = 'miscellaneous_resources';

    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'title',
        'description'
    ];
}
