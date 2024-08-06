<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->json('medications')->nullable(); // Campo para almacenar los medicamentos en JSON
            $table->decimal('total_price', 8, 2)->nullable();
            $table->string('service');
            $table->boolean('nurse_attended')->default(false);
            $table->json('vital_signs')->nullable();
            $table->text('reason')->nullable();
            $table->date('consultation_date')->nullable();
            $table->date('appointment_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_infos');
    }
}
