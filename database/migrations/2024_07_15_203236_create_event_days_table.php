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
        Schema::create('event_days', function (Blueprint $table) {
            $table->id();
            $table->string('ticketAmount');
            $table->date('refDate');
            $table->string('group');
            $table->boolean('multiday');
            $table->string('artist')->nullable();
            $table->float('price',8,2);
            $table->boolean('show')->default(true);
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->foreignId('day_id')->nullable()->constrained('days');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_days');
    }
};
