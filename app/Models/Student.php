<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'students';
    protected $primaryKey = 'std_id';
    protected $guarded = [];

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

    public function company()
    {
        return $this->belongsTo(Company::class,'std_company_id','cmp_id');
     
    }
    public function classes()
{
    return $this->belongsTo(Classes::class, 'std_classes_id', 'cls_id');
}
public function major()
{
    return $this->belongsTo(Major::class, 'std_major_id', 'mjr_id');
}
public function newsParticipants()
{
    return $this->hasMany(NewsParticipant::class, 'nwp_student_id', 'std_id');
}
}
