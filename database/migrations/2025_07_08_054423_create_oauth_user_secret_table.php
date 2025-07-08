<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oauth_client_secrets', function (Blueprint $table) {
            $table->uuid('client_id')->primary(); // sama dengan `oauth_clients.id`
            $table->string('secret'); // disimpan dalam plaintext
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth_user_secret');
    }
};
