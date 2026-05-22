<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'majors';
    protected $primaryKey = 'mjr_id';
    protected $guarded = [];

    const CREATED_AT = 'mjr_created_at';
    const UPDATED_AT = 'mjr_updated_at';
    const DELETED_AT = 'mjr_deleted_at';
   
}
