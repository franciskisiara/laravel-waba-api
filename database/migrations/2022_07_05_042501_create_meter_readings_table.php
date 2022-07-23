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
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenancy_id')->constrained('tenancies')->onDelete('cascade');
            $table->double('previous_units', 10, 2)->nullable();
            $table->double('current_units', 10, 2);
            $table->double('consumed_units', 10, 2)->nullable();
            $table->json('bill')->nullable();
            $table->string('bill_description')->nullable();
            $table->string('bill_delivery_id')->nullable();
            $table->enum('bill_delivery_status', [
                'pending', 'success', 'failed', 
            ])->default('pending');
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
        Schema::dropIfExists('meter_readings');
    }
};