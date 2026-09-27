<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureState extends Model
{
    protected $table = 'lecture_states';

    protected $primaryKey = 'lecture_state_id';

    public $timestamps = false;

    protected $fillable = [
        'lecture_id',
        'questions',
        'major_statements',
        'minor_statements',
        'mention_of_persons',
        'mention_of_creations',
        'declarations',
        'all_statements',
        'image_urls',
    ];
}
