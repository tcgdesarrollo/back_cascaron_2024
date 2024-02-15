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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('type',100);
            $table->json('to');
            $table->boolean('is_urgent')->default(false);
            $table->json('extra')->nullable();
            $table->text('sent_result')->nullable();
            $table->string('language')->default('es');
            $table->boolean('was_sent')->default(false);
            $table->integer('failed_times')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
