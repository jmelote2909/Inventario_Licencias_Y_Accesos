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
        Schema::table('teletrabajos', function (Blueprint $table) {
            $table->boolean('es_cabecera')->default(false)->after('id');
            $table->foreignId('parent_id')->nullable()->after('es_cabecera')->constrained('teletrabajos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teletrabajos', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['es_cabecera', 'parent_id']);
        });
    }
};
