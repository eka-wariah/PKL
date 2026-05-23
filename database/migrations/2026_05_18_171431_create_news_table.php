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
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('news_id');
            $table->unsignedBigInteger('news_mentor_id');
            $table->foreign('news_mentor_id')->references('mtr_id')->on('mentors')->onDelete('cascade');
            $table->unsignedBigInteger('news_academic_year');
            $table->foreign('news_academic_year')->references('acy_id')->on('academic_years')->onDelete('cascade');
            $table->date('news_date')->nullable();
            $table->time('news_start')->nullable();
            $table->time('news_ended')->nullable();
            $table->string('news_document_number')->nullable();
            $table->string('news_week_number')->nullable();
            $table->longText('news_guidance_material')->nullable();
            $table->longText('news_note')->nullable();
            $table->longText('news_problem')->nullable();
            $table->string('news_image')->nullable();
            // $table->bigInteger('news_status')->nullable();
            $table->unsignedBigInteger('news_parent_id')->nullable();
            $table->foreign('news_parent_id')->references('news_id')->on('news')->onDelete('cascade');

            $table->timestamps();
            $table->renameColumn('updated_at', 'news_updated_at');
            $table->renameColumn('created_at', 'news_created_at');
            $table->unsignedBigInteger('news_created_by')->nullable();
            $table->unsignedBigInteger('news_deleted_by')->nullable();
            $table->unsignedBigInteger('news_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'news_deleted_at');
            $table->string('news_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
