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
        Schema::create('news_participans', function (Blueprint $table) {
             $table->bigIncrements('nwp_id');

            $table->unsignedBigInteger('nwp_student_id');
            $table->foreign('nwp_student_id')->references('std_id')->on('students')->onDelete('cascade');

            $table->unsignedBigInteger('nwp_news_id');
            $table->foreign('nwp_news_id')->references('news_id')->on('news')->onDelete('cascade');

            $table->unsignedBigInteger('nwp_created_by');
            $table->foreign('nwp_created_by')->references('usr_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('nwp_updated_by')->nullable();
            $table->foreign('nwp_updated_by')->references('usr_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('nwp_deleted_by')->nullable();
            $table->foreign('nwp_deleted_by')->references('usr_id')->on('users')->onDelete('cascade');

            $table->text('nwp_sys_note')->nullable();

            $table->timestamps();
            $table->renameColumn('created_at', 'nwp_created_at');
            $table->renameColumn('updated_at', 'nwp_updated_at');

            $table->softDeletes();
            $table->renameColumn('deleted_at', 'nwp_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_participans');
    }
};
