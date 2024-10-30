<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Unique slug for URL
            $table->string('thumbnail')->nullable(); // URL or path for thumbnail image
            $table->text('content'); // News content
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Link to categories table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table (author/admin)
            $table->timestamp('upload_time')->nullable(); // Optional, auto-fill on publish
            $table->json('addImage')->nullable(); // JSON array for multiple images
            $table->enum('status', ['review', 'publish'])->default('review'); // Status of news
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}

