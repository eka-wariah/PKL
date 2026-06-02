<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
   
    protected $primaryKey = 'att_id';
    protected $guarded = [];

    // const CREATED_AT = 'att_created_at';
    // const UPDATED_AT = 'att_updated_at';
    // const DELETED_AT = 'att_deleted_at';
}
