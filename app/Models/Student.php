<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded =[];
    protected $primaryKey = 'std_id';

    const CREATED_AT = 'std_created_at';
    const UPDATED_AT = 'std_updated_at';
    const DELETED_AT = 'std_deleted_at';


     public function user()
    {
        return $this->belongsTo(User::class, 'std_usr_id', 'usr_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'std_classes_id', 'cls_id');
    }
     public function mentorAssignment()
    {
        return $this->hasOne(mentorAssignments::class, 'mas_student_id', 'std_id');
    }
}
