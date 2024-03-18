<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->references('id')->on('categories');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('recovery_email')->nullable();
            $table->integer('is_recovery_enable')->default(0);
            $table->integer('is_logo_enable')->default(0);
            $table->string('username')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('profile_id')->nullable();
            $table->string('plain_password')->nullable();
            $table->string('password')->nullable();
            $table->string('page_url')->nullable();
            $table->string('barcode_url')->nullable();
            $table->string('q1')->nullable();
            $table->string('a1')->nullable();
            $table->string('q2')->nullable();
            $table->string('a2')->nullable();
            $table->string('q3')->nullable();
            $table->string('a3')->nullable();
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
        Schema::dropIfExists('peoples');
    }
}
