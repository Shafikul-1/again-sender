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
        Schema::create('mailsetup', function (Blueprint $table) {
            $table->id();
            $table->string('mail_transport');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_username');
            $table->string('mail_password');
            $table->string('mail_encryption');
            $table->string('mail_from');
            $table->string('mail_sender_name');
            $table->string('sender_company_logo')->nullable();
            $table->string('sender_website')->nullable();
            $table->integer('sender_number')->nullable();
            $table->json('other_links');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailsetup');
    }
};
