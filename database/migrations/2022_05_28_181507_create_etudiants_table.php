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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('cne')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', array('M', 'F'));
            $table->date('date_de_naissance');
            $table->string('email');
            $table->string('tel');
            $table->string('adresse');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            
            
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('parentts')
            ->nullOnDelete()
            ->restrictOnUpdate();
            
            
            $table->unsignedBigInteger('classe_id')->nullable();
            $table->foreign('classe_id')->references('id')->on('classes')
            ->nullOnDelete()
            ->restrictOnUpdate();

            
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
        Schema::dropIfExists('etudiants');
    }
};
