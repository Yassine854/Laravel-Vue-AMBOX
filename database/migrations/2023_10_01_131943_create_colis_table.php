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
        Schema::create('colis', function (Blueprint $table) {
            //Colis
            $table->id();
            $table->double("prix");
            $table->integer("Nb_pieces");
            $table->string("designation");
            $table->double("poid");
            $table->boolean("echange");
            $table->string("type");
            $table->boolean("fragile");
            //Client
            $table->integer("tel");
            $table->string("nom");
            $table->string("address");
            $table->integer("tel2")->nullable();
            $table->string("gouvernorat");
            $table->string("delegation");
            $table->string("localite");
            $table->string("commentaire");
            $table->boolean("livraison")->default(false);

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
        Schema::dropIfExists('colis');
    }
};
