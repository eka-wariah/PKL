<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'classes';
    protected $primaryKey = 'cls_id';
    protected $guarded = [];

    const CREATED_AT = 'cls_created_at';
    const UPDATED_AT = 'cls_updated_at';
    const DELETED_AT = 'cls_deleted_at';

    public function cls_major()
    {
        return $this->belongsTo(Major::class, 'cls_major_id');
    }
    public function cls_academic()
    {
        return $this->belongsTo(AcademicYear::class, 'cls_acy_id');
    }
    public function cls_homeroom()
    {
        return $this->belongsTo(User::class, 'cls_homeroom_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'std_classes_id', 'cls_id');
    }
}
