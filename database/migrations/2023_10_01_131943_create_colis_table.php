<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->id()->start_from(100000000);
            $table->double("prix");
            $table->integer("Nb_pieces");
            $table->string("designation");
            $table->double("poid");
            $table->boolean("echange");
            $table->string("type");
            $table->boolean("fragile");
            $table->string("etat")->default('En attente');
            //Client
            $table->integer("tel");
            $table->string("nom");
            $table->string("address");
            $table->integer("tel2")->nullable();
            $table->string("gouvernorat");
            $table->string("delegation");
            $table->string("localite");
            $table->string("commentaire")->nullable();
            $table->unsignedBigInteger('expediteur_id');
            $table->foreign('expediteur_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->boolean("payer")->default(0);
            $table->timestamps();

        });

        DB::statement('ALTER TABLE colis AUTO_INCREMENT = 100000000;');
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
