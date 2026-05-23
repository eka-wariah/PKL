<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'companies';
    protected $primaryKey = 'cmp_id';
    protected $guarded = [];

    const CREATED_AT = 'cmp_created_at';
    const UPDATED_AT = 'cmp_updated_at';
    const DELETED_AT = 'cmp_deleted_at';
}
