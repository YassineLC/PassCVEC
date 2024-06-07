<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassCvecRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_cvec_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ine');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('adresse')->nullable();
            $table->integer('code_postal');
            $table->string('ville');
            $table->integer('numero_chambre')->nullable();
            $table->boolean('is_in_residence');
            $table->string('residence')->nullable();
            $table->string('statut')->default('A traiter');
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
        Schema::dropIfExists('pass_cvec_requests');
    }
}
