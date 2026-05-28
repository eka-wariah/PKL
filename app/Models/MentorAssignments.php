<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorAssignments extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'mas_id';

    const CREATED_AT = 'mas_created_at';
    const UPDATED_AT = 'mas_updated_at';
    const DELETED_AT = 'mas_deleted_at';

    public function student()
    {
        return $this->belongsTo(Student::class, 'mas_student_id', 'std_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mas_mentor_id', 'mtr_id');
    }
    
}
