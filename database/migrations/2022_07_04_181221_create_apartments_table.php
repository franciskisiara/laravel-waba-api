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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('caretaker_id')->constrained('users')->onDelete('cascade');
            $table->decimal('flat_rate_limit', 6, 2)->default(0.00);
            $table->decimal('flat_rate', 6, 2)->default(0.00);
            $table->decimal('unit_rate', 6, 2)->default(0.00);
            $table->timestamps();

            $table->index(['name', 'caretaker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
};
