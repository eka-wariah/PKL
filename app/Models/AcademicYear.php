<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'academic_years';
    protected $primaryKey = 'acy_id';
    protected $guarded = [];

    const CREATED_AT = 'acy_created_at';
    const UPDATED_AT = 'acy_updated_at';
    const DELETED_AT = 'acy_deleted_at';

    public function getAcademicYearAttribute()
    {
        return $this->acy_year . '/' . ($this->acy_year + 1);
    }
    public function getIsActiveNowAttribute()
{
    $now = Carbon::now();

    $startYear = $this->acy_year;
    $endYear   = $this->acy_year + 1;

    // Batas akademik: Juli - Juni
    $startDate = Carbon::create($startYear, 7, 1);
    $endDate   = Carbon::create($endYear, 6, 30);

    return $now->between($startDate, $endDate);
}
}
