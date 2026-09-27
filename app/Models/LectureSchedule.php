<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureSchedule extends Model
{
    protected $table = 'lecture_schedule';

    protected $primaryKey = 'lecture_schedule_id';

    public $timestamps = false;

    protected $fillable = [
        'day',
        'start_time',
        'period',
        'teacher_id',
    ];
}
