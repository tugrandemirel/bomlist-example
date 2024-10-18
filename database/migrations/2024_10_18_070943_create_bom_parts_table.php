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
        Schema::create('bom_parts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('bom_id',);
            $table->unsignedBigInteger('part_id',);
            $table->string('quantity',);
            $table->timestamps();

            $table->foreign('bom_id')->references('id')->on('boms');
            $table->foreign('part_id')->references('id')->on('parts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_parts');
    }
};
