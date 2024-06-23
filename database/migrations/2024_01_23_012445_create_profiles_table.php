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
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('photo',255)->nullable();
            $table->string('profession', 60)->nullable();
            $table->string('about', 255)->nullable(); 
            $table->string('twitter', 100)->nullable(); 
            $table->string('linkedin', 100)->nullable(); 
            $table->string('facebook', 100)->nullable();


//primera forma

$table->unsignedBigInteger('user_id')->unique();
$table->foreign('user_id')
->references('id')
->on('users')
->onDelete('cascade')
->onUpdate('cascade');

//segunda forma(esto es por convencion  es lo mismo que arriba pero abreviado)

//$table->foreignID('user_id')->constrained();






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
        Schema::dropIfExists('profiles');
    }
};
