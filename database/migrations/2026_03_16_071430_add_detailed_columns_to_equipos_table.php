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
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('centro')->nullable()->after('nombre');
            $table->string('planta')->nullable()->after('centro');
            $table->string('zona')->nullable()->after('planta');
            $table->string('dispositivotipo')->nullable()->after('zona');
            $table->string('dispositivomarca')->nullable()->after('dispositivotipo');
            $table->string('dispositivomodelo')->nullable()->after('dispositivomarca');
            $table->string('dispositivoserial')->nullable()->after('dispositivomodelo');
            $table->string('dispositivomac')->nullable()->after('dispositivoserial');
            $table->string('tipoconexion')->nullable()->after('dispositivomac');
            $table->string('conectado_a')->nullable()->after('tipoconexion');
            $table->boolean('compartida')->default(false)->after('conectado_a');
            $table->string('empleadocodigo')->nullable()->after('compartida');
            $table->string('empleadonombre')->nullable()->after('empleadocodigo');
            $table->string('empleadomentor')->nullable()->after('empleadonombre');
            $table->string('empleado_taquilla')->nullable()->after('empleadomentor');
            $table->string('firefox')->nullable()->after('empleado_taquilla');
            $table->string('sage')->nullable()->after('firefox');
            $table->string('t_plant')->nullable()->after('sage');
            $table->string('t_stock')->nullable()->after('t_plant');
            $table->string('instalado')->nullable()->after('t_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            //
        });
    }
};
