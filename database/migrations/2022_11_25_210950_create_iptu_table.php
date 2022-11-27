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
        Schema::create('iptu', function (Blueprint $table) {
            $table->id();
            $table->string('nrinscr');
            $table->integer('cdlogradou');
            $table->string('tplogradou');
            $table->string('nmlogradou');
            $table->string('nrimovel');
            $table->string('incompl');
            $table->string('nrquadra');
            $table->string('nrlote');
            $table->integer('cdbairro');
            $table->string('nmbairro');
            $table->integer('insubprinc');
            $table->integer('ttsublot');
            $table->integer('nrfrenter');
            $table->integer('areaterr');
            $table->integer('areatest');
            $table->integer('areaedif');
            $table->integer('propriedad');
            $table->integer('situacao');
            $table->integer('topografia');
            $table->integer('nivel');
            $table->integer('solo');
            $table->integer('uso');
            $table->integer('uso1');
            $table->integer('formauso');
            $table->integer('localizac');
            $table->integer('nrelevador');
            $table->integer('nrgaragem');
            $table->integer('tpedif1');
            $table->integer('tpedif2');
            $table->integer('posicaoedf');
            $table->integer('estrutura');
            $table->integer('esquadria');
            $table->integer('piso');
            $table->integer('forro');
            $table->integer('insteletri');
            $table->integer('ininstsani');
            $table->integer('revinterno');
            $table->integer('acinterno');
            $table->integer('revexterno');
            $table->integer('acexterno');
            $table->integer('cobertura');
            $table->integer('conserva');
            $table->integer('agua');
            $table->integer('esgoto');
            $table->integer('ocupacao');
            $table->integer('fecho');
            $table->integer('passeio');
            $table->integer('nrarvores');
            $table->integer('nrpostes');
            $table->integer('cdedificio');
            $table->float('vlvenal', 24, 16)->nullable();
            $table->integer('nrpaviment');
            $table->integer('nrvagascob');
            $table->integer('nrvagasdes');
            $table->string('nmedificio');
            $table->integer('pontedific');
            $table->float('VALR_M2_EDF_LAN', 24, 16)->nullable();
            $table->float('VALR_M2_TERRENO_LAN', 24, 16)->nullable();
            $table->float('VALR_M2_ZPA_LAN', 24, 16)->nullable();
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
        Schema::dropIfExists('iptu');
    }
};
