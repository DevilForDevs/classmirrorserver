<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $table = 'syllabus';

    protected $primaryKey = 'topic_id';

    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'class_subject_id ',
        'paper_id',
        'topic',
        'total_lectures',
        'teacher_id',
        'author',
        'description',
        'semester'
    ];
}
