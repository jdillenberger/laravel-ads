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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->text('content');
            $table->enum('type', ['image', 'video', 'html']);
            $table->datetime('start_date')->useCurrent();
            $table->datetime('end_date')->default(now()->addYears(100));
            $table->enum('status', ['active', 'paused', 'draft'])->default('draft');
            $table->foreignId('campaign_id')->references('id')->on('ad_campaigns')->cascadeOnDelete();
            $table->foreignId('placement_id')->references('id')->on('ad_placements')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
