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
        Schema::create('ad_interactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['click', 'impression']);
            $table->foreignId('ad_id')->references('id')->on('advertisements');
            $table->float('lattitude')->nullable();
            $table->float('longitude')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('ip_address', 45);
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_impressions');
    }
};
