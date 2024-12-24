<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->string('title', 255); 
            $table->text('description')->nullable(); 
            $table->string('url')->unique();
            $table->timestamp('published_at')->index(); //index for faster search
            $table->timestamps();
            //relationship columns  - Foreign keys
            $table->string('source_id')->index();  
            $table->string('author_id')->index();  
            $table->string('category_id')->index();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
