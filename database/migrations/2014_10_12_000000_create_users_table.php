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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->integer('role')->nullable();
            $table->boolean('disabled')->default(false);
            $table->string('entreprise')->nullable();
            $table->string('gouvernorat')->nullable();
            $table->string('delegation')->nullable();
            $table->string('localite')->nullable();
            $table->string('address')->nullable();
            $table->double('prix_livraison')->nullable();
            $table->double('prix_retour')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
