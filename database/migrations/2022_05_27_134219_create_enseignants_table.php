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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('cin');
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', array('M', 'F'));
            $table->string('titre');
            $table->string('email');
            $table->string('tel');
            $table->string('adresse');
            $table->float('salaire')->nullable();
            $table->text('bio')->nullable();
            $table->string('cv')->nullable();
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
        Schema::dropIfExists('enseignants');
    }
};
