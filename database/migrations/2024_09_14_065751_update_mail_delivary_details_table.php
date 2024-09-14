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
        Schema::table('mail_delivary_details', function (Blueprint $table) {
            $table->foreignId('mailsetup_id')->references('id')->on('mailsetup')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_delivary_details', function (Blueprint $table) {
            //
        });
    }
};
