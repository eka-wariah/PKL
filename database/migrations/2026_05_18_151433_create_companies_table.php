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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('cmp_id');
            $table->string('cmp_name');
            $table->string('cmp_adress');
            $table->timestamps();
            $table->renameColumn('updated_at', 'cmp_updated_at');
            $table->renameColumn('created_at', 'cmp_created_at');
            $table->unsignedBigInteger('cmp_created_by')->nullable();
            $table->unsignedBigInteger('cmp_deleted_by')->nullable();
            $table->unsignedBigInteger('cmp_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'cmp_deleted_at');
            $table->string('cmp_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
