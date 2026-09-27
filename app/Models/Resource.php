<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'owner_row_id',
        'owner_table',
        'title',
        'url',
    ];

    public function announcements()
    {
        return $this->hasMany(
            Announcement::class,
            'resource_id',
            'resource_id'
        );
    }
}
