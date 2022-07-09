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
            $table->integer('flat_rate_limit')->default(0);
            $table->decimal('flat_rate')->default(0);
            $table->decimal('unit_rate')->default(0);
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
