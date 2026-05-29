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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('std_id');
            $table->unsignedBigInteger('std_usr_id');
            $table->foreign('std_usr_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->string('std_nis')->nullable();
            $table->string('std_nisn')->nullable();
            $table->unsignedBigInteger('std_classes_id')->nullable();
            $table->foreign('std_classes_id')->references('cls_id')->on('classes')->onDelete('cascade');
            $table->unsignedBigInteger('std_company_id')->nullable();
            $table->foreign('std_company_id')->references('cmp_id')->on('companies')->onDelete('cascade');
            
            // $table->string('std_name');
            $table->string('std_nickname')->nullable();
            $table->timestamps();
            $table->renameColumn('updated_at', 'std_updated_at');
            $table->renameColumn('created_at', 'std_created_at');
            $table->unsignedBigInteger('std_created_by')->nullable();
            $table->unsignedBigInteger('std_deleted_by')->nullable();
            $table->unsignedBigInteger('std_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'std_deleted_at');
            $table->string('std_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
