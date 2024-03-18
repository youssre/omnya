<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->references('id')->on('categories');
            $table->string('email')->nullable();
            $table->string('recovery_email')->nullable();
            $table->integer('is_recovery_enable')->default(0);
            $table->integer('is_logo_enable')->default(0);
            $table->string('plain_password')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_id')->nullable();
            $table->string('page_url')->nullable();
            $table->string('barcode_url')->nullable();
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
        Schema::dropIfExists('google_users');
    }
}
