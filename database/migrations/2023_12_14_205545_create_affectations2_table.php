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
        Schema::create('affectations2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livreur_id');
            $table->foreign('livreur_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('colis_id');
            $table->foreign('colis_id')
            ->references('id')->on('colis')->onDelete('cascade');
            $table->timestamps();
            $table->integer('voyage_id');
            $table->boolean('voyage_done')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affectations2');
    }
};
