<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'classes';

    protected $primaryKey = 'class_id';

    protected $fillable = [
        'session',
        'major_subject_id',
        'cr_name',
        'description',
    ];
}
