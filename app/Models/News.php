<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded =[];
    protected $primaryKey = 'news_id';
    protected $table = 'news'; 

    const CREATED_AT = 'news_created_at';
    const UPDATED_AT = 'news_updated_at';
    const DELETED_AT = 'news_deleted_at';

    public function newsParent()
    {
        return $this->belongsTo(News::class, 'news_parent_id', 'news_id');
    }
}
