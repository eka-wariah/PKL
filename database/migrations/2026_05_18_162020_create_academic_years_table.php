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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->bigIncrements('acy_id');
            $table->bigInteger('acy_year');
            $table->bigInteger('acy_status')->default(1);
            $table->timestamps();
            $table->renameColumn('updated_at', 'acy_updated_at');
            $table->renameColumn('created_at', 'acy_created_at');
            $table->unsignedBigInteger('acy_created_by')->nullable();
            $table->unsignedBigInteger('acy_deleted_by')->nullable();
            $table->unsignedBigInteger('acy_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'acy_deleted_at');
            $table->string('acy_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
