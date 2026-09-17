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
        if (!Schema::hasColumn('nodes', 'node_icon')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->string('node_icon')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('nodes', 'node_icon')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->dropColumn('node_icon');
            });
        }
    }
};
