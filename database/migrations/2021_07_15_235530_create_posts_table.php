<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // auto incrementing primary key with name id

            // $table->integer('user_id')->unsigned()->index(); // One way of doing it, with the the index added for speed.

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key referecing the user table and id column. Also, when a user is deleted, the cascade causes all posts form that user to also be deleted. 

            $table->text('body');
            $table->timestamps(); // shorthand that gives a created_at and updated_at columns.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
