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
        Schema::table('topups', function (Blueprint $table) {
            $table->enum('type', ['manual', 'auto'])->default('manual');
            $table->text('link')->nullable();
            $table->string('callback_status')->nullable();
            $table->integer('cost')->default(0);
            $table->string('reference')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->string('qris_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('link');
            $table->dropColumn('callback_status');
            $table->dropColumn('cost');
            $table->dropColumn('reference');
            $table->dropColumn('paid_at');
            $table->dropColumn('expired_at');
            $table->dropColumn('qris_image');
        });
    }
};
