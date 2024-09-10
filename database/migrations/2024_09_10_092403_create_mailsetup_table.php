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
            $table->string('department');
            $table->string('whatsapp_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('linkdin_link')->nullable();
            $table->string('website')->nullable();
            $table->text('profile_link');
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
