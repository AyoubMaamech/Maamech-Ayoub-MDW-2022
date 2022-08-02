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
        Schema::create('parentts', function (Blueprint $table) {
            $table->id();
            $table->string('cnp')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', array('M', 'F'));
            $table->string('occupation');
            $table->string('email');
            $table->string('tel');
            $table->string('adresse');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
            ->nullOnDelete()
            ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parentts');
    }
};
