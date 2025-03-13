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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('odp_id')->nullable();
            $table->string('name');
            $table->string('number_id');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('identity')->nullable();
            $table->string('address')->nullable();
            $table->date('regist')->useCurrent();
            $table->integer('due')->default(0);
            $table->string('ip')->nullable();
            $table->string('mac')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('type')->default('ppp');
            $table->string('secret_username')->nullable();
            $table->string('secret_password')->nullable();
            $table->enum('status', ['active', 'nonactive', 'suspended', 'blacklisted', 'pending'])->default('active');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('package_id')->references('id')->on('packages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('odp_id')->references('id')->on('odps')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
