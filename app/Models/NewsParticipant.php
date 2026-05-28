<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsParticipant extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'nwp_id';
    protected $table = 'news_participans';


    const CREATED_AT = 'nwp_created_at';
    const UPDATED_AT = 'nwp_updated_at';
    const DELETED_AT = 'nwp_deleted_at';

    public function student()
    {
        return $this->belongsTo(Student::class, 'nwp_student_id', 'std_id');
    }
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'nwp_mentor_id', 'mtr_id');
    }
}
