<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('empleado_nombre')->nullable();
            
            // Red Cimacableados
            $blueprint->string('red_cima_u')->nullable();
            $blueprint->string('red_cima_p')->nullable();
            
            // Correo
            $blueprint->string('correo_u')->nullable();
            $blueprint->string('correo_p')->nullable();
            $blueprint->string('correo_p_sage')->nullable(); // Correo electrónico P Sage
            $blueprint->string('correo_u_reest')->nullable(); // Correo electrónico U (reest)
            $blueprint->string('correo_p_reest')->nullable(); // Correo electrónico P (reest)
            
            // Sage
            $blueprint->string('sage_u')->nullable();
            $blueprint->string('sage_p')->nullable();
            
            // ERP
            $blueprint->string('erp_u')->nullable();
            $blueprint->string('erp_p')->nullable();
            
            // GW107
            $blueprint->string('gw107_u')->nullable();
            $blueprint->string('gw107_p')->nullable();
            
            // Slack
            $blueprint->string('slack_u')->nullable();
            $blueprint->string('slack_p')->nullable();
            $blueprint->string('slack_id')->nullable();
            
            // Hubspot
            $blueprint->string('hubspot_u')->nullable();
            $blueprint->string('hubspot_p')->nullable();
            
            // Otros (U only or specific)
            $blueprint->string('microsoft_u')->nullable();
            $blueprint->string('trello_u')->nullable();
            $blueprint->string('zoom_u')->nullable();
            $blueprint->string('vodafone_u')->nullable();
            $blueprint->string('chatgpt_u')->nullable();
            
            // MRW
            $blueprint->string('mrw_u')->nullable();
            $blueprint->string('mrw_p')->nullable();
            
            // Pallet Ways+
            $blueprint->string('pallet_ways_u')->nullable();
            $blueprint->string('pallet_ways_p')->nullable();
            
            // OpenProject
            $blueprint->string('openproyect_u')->nullable();
            $blueprint->string('openproyect_p')->nullable();

            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
