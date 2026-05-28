<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'news_id';
    protected $table = 'news';

    const CREATED_AT = 'news_created_at';
    const UPDATED_AT = 'news_updated_at';
    const DELETED_AT = 'news_deleted_at';

    public function newsParent()
    {
        return $this->belongsTo(News::class, 'news_parent_id', 'news_id');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'news_academic_year', 'acy_id');
    }
    public function participants()
    {
        return $this->hasMany(NewsParticipant::class, 'nwp_news_id','news_id');
    }
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'news_mentor_id', 'mtr_id');
    }
}
