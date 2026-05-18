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
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('cls_id');
            $table->string('cls_code');
            $table->string('cls_level');
            $table->unsignedBigInteger('cls_major_id');
            $table->foreign('cls_major_id')->references('mjr_id')->on('majors')->onDelete('cascade');
            $table->bigInteger('cls_number');
            $table->unsignedBigInteger('cls_homeroom_id');
            $table->foreign('cls_homeroom_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('cls_acy_id');
            $table->foreign('cls_acy_id')->references('acy_id')->on('academic_years')->onDelete('cascade');
            $table->timestamps();
            $table->renameColumn('updated_at', 'cls_updated_at');
            $table->renameColumn('created_at', 'cls_created_at');
            $table->unsignedBigInteger('cls_created_by')->nullable();
            $table->unsignedBigInteger('cls_deleted_by')->nullable();
            $table->unsignedBigInteger('cls_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'cls_deleted_at');
            $table->string('cls_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
