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
        Schema::table('voucher_templates', function (Blueprint $table) {
            $table->text('footer')->nullable()->after('html_vc');
            $table->text('header')->nullable()->after('html_vc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_templates', function (Blueprint $table) {
            $table->dropColumn('footer');
            $table->dropColumn('header');
        });
    }
};
