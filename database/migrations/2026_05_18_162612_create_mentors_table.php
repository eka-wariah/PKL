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
        Schema::create('mentors', function (Blueprint $table) {
            $table->bigIncrements('mtr_id');
            $table->unsignedBigInteger('mtr_usr_id');
            $table->foreign('mtr_usr_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->string('mtr_gtk');
            $table->timestamps();
            $table->renameColumn('updated_at', 'mtr_updated_at');
            $table->renameColumn('created_at', 'mtr_created_at');
            $table->unsignedBigInteger('mtr_created_by')->nullable();
            $table->unsignedBigInteger('mtr_deleted_by')->nullable();
            $table->unsignedBigInteger('mtr_updated_by')->nullable();
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
        Schema::dropIfExists('mentors');
    }
};
