<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $guarded =[];
    protected $primaryKey = 'mtr_id';

    const CREATED_AT = 'mtr_created_at';
    const UPDATED_AT = 'mtr_updated_at';
    const DELETED_AT = 'mtr_deleted_at';

    public function user()
    {
        return $this->belongsTo(User::class,'mtr_usr_id','usr_id');
        // default: FK = user_id, PK = id
    }
}
