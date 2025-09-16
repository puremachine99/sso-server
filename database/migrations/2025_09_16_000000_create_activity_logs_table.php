<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // who did it
            $table->nullableMorphs('causer'); // causer_type, causer_id

            // what is affected
            $table->nullableMorphs('subject'); // subject_type, subject_id

            // event key and human description
            $table->string('event')->index();
            $table->string('description')->nullable();

            // request context
            $table->string('method', 10)->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            // extra details
            $table->json('properties')->nullable();

            $table->timestamps();

            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

