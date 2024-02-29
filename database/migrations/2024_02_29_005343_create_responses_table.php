<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('method')
                ->nullable();
            $table->integer('http_status');
            $table->string('slug')
                ->nullable();
            $table->text('body')
                ->nullable();
            $table->unique(['slug', 'method']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
