<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $table = 'syllabus';

    protected $primaryKey = 'topic_id';

    public $timestamps = false;

    protected $fillable = [
        'session',
        'topic',
        'total_lectures',
        'author',
        'description',
        'semester'
    ];
}
