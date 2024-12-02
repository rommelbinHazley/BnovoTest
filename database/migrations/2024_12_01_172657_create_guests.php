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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('surname', 128);
            $table->string('email', 128)->unique();
            $table->string('phone', 128)->unique();
            // По-сути, страну не совсем корректно здесь хранить, надо бы id на таблицу со страной.
            $table->string('country', 128);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
