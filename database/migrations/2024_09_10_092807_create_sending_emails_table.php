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
        Schema::create('sending_emails', function (Blueprint $table) {
            $table->id();
            $table->string('mails');
            $table->string('mail_form');
            $table->enum('status', ['noaction', 'pending', 'netdisable', 'fail', 'success'])->default('noaction');
            $table->timestamp('send_time');
            $table->integer('wait_minute')->default(0);
            $table->foreignId('mail_content_id')->references('id')->on('mail_contents')->cascadeOnDelete();
            $table->foreignId('mailsetup_id')->references('id')->on('mailsetup')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sending_emails');
    }
};
