<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up() {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purpose');
            $table->foreignId('owner')->constrained('users')->onDelete('cascade');
            $table->boolean('owner_spouse')->nullable();
            $table->unsignedInteger('owner_company')->nullable();
            $table->foreignId('acquirer')->constrained('users')->onDelete('cascade');
            $table->boolean('acquirer_spouse')->nullable();
            $table->unsignedInteger('acquirer_company')->nullable();
            $table->unsignedInteger('property');
            $table->double('price');
            $table->double('tribute');
            $table->double('condominium');
            $table->unsignedInteger('due_date');
            $table->unsignedInteger('deadline');
            $table->date('start_at');
            $table->timestamps();

            $table->foreign('owner_company')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreign('acquirer_company')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreign('property')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contracts');
    }
}
