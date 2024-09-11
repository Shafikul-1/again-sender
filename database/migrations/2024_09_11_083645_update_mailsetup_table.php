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
        Schema::table('mailsetup', function (Blueprint $table) {
            $table->string('sender_company_logo')->nullable();
            $table->string('sender_website')->nullable();
            $table->integer('sender_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mailsetup', function (Blueprint $table) {
            //
        });
    }
};
