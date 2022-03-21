<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closets', function (Blueprint $table) {
            $table->id();   

            $table->unsignedInteger('user_id');
            $table->String('username')->nullable();
            $table->String('email')->nullable();
            $table->String('password')->nullable();
            $table->String('country')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closets');
    }
}
