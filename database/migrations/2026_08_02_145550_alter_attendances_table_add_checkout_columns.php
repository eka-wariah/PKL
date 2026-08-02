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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('att_checkout_photo')->nullable()->after('att_type');
            $table->decimal('att_checkout_latitude', 10, 8)->nullable()->after('att_checkout_photo');
            $table->decimal('att_checkout_longitude', 11, 8)->nullable()->after('att_checkout_latitude');
            $table->string('att_checkout_address')->nullable()->after('att_checkout_longitude');
            $table->time('att_checkout_time')->nullable()->after('att_checkout_address');
             $table->enum('att_type_checkout', ['masuk', 'pulang'])->default('pulang')->nullable()->after('att_checkout_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'att_checkout_photo',
                'att_checkout_latitude',
                'att_checkout_longitude',
                'att_checkout_address',
                'att_checkout_time',
            ]);
        });
    }
};
