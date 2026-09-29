<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lectures';

    protected $primaryKey = 'lecture_id';

    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'topic_id',
        'started_at',
        'ended_at',
        'teacher_id',
        'status',
        'description',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
}
