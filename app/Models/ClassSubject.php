<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subjects';

    protected $primaryKey = 'class_subject_id';

    protected $fillable = [
        'class_id',
        'subject_id',
        'course_type_id',
    ];
}
