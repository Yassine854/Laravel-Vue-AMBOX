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
        Schema::create('paiement', function (Blueprint $table) {
            $table->id();
            $table->double('livraison')->default(0);
            $table->double('expedition')->default(0);
            $table->unsignedBigInteger('colis_id');
            $table->foreign('colis_id')
            ->references('id')->on('colis')->onDelete('cascade');
            $table->unsignedBigInteger('expediteur_id');
            $table->foreign('expediteur_id')
            ->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('paiement');
    }
};
