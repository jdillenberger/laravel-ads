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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('title', 20)->nullable();
            $table->string('mobile', 25)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('notes')->nullable();
            $table->string('locale', 35)->default('de-DE');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
