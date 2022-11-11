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
        Schema::create('receive_messages', function (Blueprint $table) {
            $table->id();
            $table->string('email_id_message', 255)->unique();
            $table->string('subject_message', 255)->nullable();
            $table->string('from_mail_message', 255)->nullable();
            $table->string('from_fullname_message', 255)->nullable();
            $table->longText('html_message')->nullable();
            $table->string('folder_message')->nullable();
            $table->string('received_message')->nullable();
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
        Schema::dropIfExists('received_emails');
    }
};
