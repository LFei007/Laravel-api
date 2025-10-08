<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_streams_table.php

    public function up(): void
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id(); // Unique ID for the stream itself
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who is streaming?
            $table->string('stream_id')->unique(); // A unique ID for this specific stream session (e.g., from WebRTC/Zego)
            $table->string('title'); // The title of the stream
            $table->boolean('is_active')->default(true); // Is the stream currently live?
            $table->timestamps(); // created_at, updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streams');
    }
};
