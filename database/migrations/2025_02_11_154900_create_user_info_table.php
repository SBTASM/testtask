<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * id
     * email
     * firstname
     * lastname
     * age
     * country
     * city
     * date
     */
    public function up(): void
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();

            $table->string('email'); //M.b. unique
            $table->string('firstname');
            $table->string('lastname');

            $table->unsignedSmallInteger('age')->default(0);

            $table->string('country');
            $table->string('city');
            $table->date('date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_info');
    }
};
