<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('backoffice_users', function (Blueprint $table) {
            $table->id();
            
            // Informations de base
            $table->string('given_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('matricule')->nullable()->unique();
            $table->string('function')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('establishment')->nullable();
            $table->string('postal_code')->nullable();
            
            // Attributs supplémentaires de Shibboleth
            $table->string('eppn')->nullable()->unique();
            $table->string('display_name')->nullable();
            $table->string('cn')->nullable();
            $table->string('unscoped_affiliation')->nullable();
            $table->string('uid')->nullable();
            $table->string('remote_user')->nullable();
            
            // Rôles et permissions pour le backoffice
            $table->string('role')->default('user');
            $table->boolean('is_active')->default(true);
            
            // Informations de connexion
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backoffice_users');
    }
};