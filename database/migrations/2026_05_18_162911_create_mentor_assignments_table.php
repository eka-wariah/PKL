<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mentor_assignments', function (Blueprint $table) {
            $table->bigIncrements('mas_id');
            $table->unsignedBigInteger('mas_student_id');
            $table->foreign('mas_student_id')->references('std_id')->on('students')->onDelete('cascade');
            $table->unsignedBigInteger('mas_mentor_id');
            $table->foreign('mas_mentor_id')->references('mtr_id')->on('mentors')->onDelete('cascade');
            $table->unsignedBigInteger('mas_academic_id');
            $table->foreign('mas_academic_id')->references('acy_id')->on('academic_years')->onDelete('cascade');
            $table->timestamps();
            $table->renameColumn('updated_at', 'mtr_updated_at');
            $table->renameColumn('created_at', 'mtr_created_at');
            $table->unsignedBigInteger('mas_created_by')->nullable();
            $table->unsignedBigInteger('mas_deleted_by')->nullable();
            $table->unsignedBigInteger('mas_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'mtr_deleted_at');
            $table->string('mtr_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_assignments');
    }
};
