<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('response_id');
            $table->text('headers')
                ->nullable();
            $table->text('content')
                ->nullable();
            $table->foreign('response_id')
                ->references('id')
                ->on('responses')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
