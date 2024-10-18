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
        Schema::create('bom_childrens', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('parent_bom_id');
            $table->unsignedBigInteger('child_bom_id');
            $table->string('quantity');
            $table->timestamps();

            $table->foreign('parent_bom_id')->references('id')->on('boms');
            $table->foreign('child_bom_id')->references('id')->on('boms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_childrens');
    }
};
