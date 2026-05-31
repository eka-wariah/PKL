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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('att_id');
            $table->unsignedBigInteger('att_std_id');
            $table->date('att_date');
            $table->tinyInteger('att_status')->default(1)->comment('1=hadir, 2=izin, 3=sakit, 4=alpha');
            $table->string('att_photo')->nullable();
            $table->decimal('att_latitude', 10, 8)->nullable();
            $table->decimal('att_longitude', 11, 8)->nullable();
            $table->string('att_address')->nullable();
            $table->time('att_time')->nullable();
            $table->enum('att_type', ['masuk', 'pulang'])->default('masuk');
            $table->unsignedBigInteger('att_created_by')->nullable();
            $table->unsignedBigInteger('att_updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('att_std_id')->references('std_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
