<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequiredTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('patients', function (Blueprint $table) {
        $table->increments('id');
        $table->string('id_type');
        $table->string('id_number')->unique();
        $table->string('name');
        $table->date('birthday');
        $table->string('gender');
        $table->string('phone');
        $table->string('address');
        $table->timestamps();
      });
      Schema::create('rooms', function (Blueprint $table) {
        $table->increments('id');
        $table->string('room_bed');
        $table->integer('cost_per_day');
        $table->timestamps();
      });
      Schema::create('departments', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamps();
      });
      Schema::create('treatment_categories', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamps();
      });
      Schema::create('doctors', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->integer('department_id')->unsigned();
        $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('treatments', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->integer('cost');
        $table->integer('category_id')->unsigned();
        $table->foreign('category_id')->references('id')->on('treatment_categories')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('medical_records', function (Blueprint $table) {
        $table->increments('id');
        $table->string('type');
        $table->integer('patient_id')->unsigned();
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('reservations', function (Blueprint $table) {
        $table->increments('id');
        $table->dateTime('starting_date');
        $table->dateTime('ending_date');
        $table->dateTime('enter_date')->nullable();
        $table->dateTime('leave_date')->nullable();
        $table->integer('room_id')->unsigned();
        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        $table->integer('medical_record_id')->unsigned()->nullable();
        $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('diagnostics', function (Blueprint $table) {
        $table->increments('id');
        $table->text('diagnostic')->nullable();
        $table->text('complaint')->nullable();
        $table->date('outpatient_date');
        $table->integer('doctor_id')->unsigned();
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        $table->integer('medical_record_id')->unsigned()->nullable();
        $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('medical_records_treatments', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('amount');
        $table->integer('treatment_id')->unsigned();
        $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
        $table->integer('medical_record_id')->unsigned();
        $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('payment_receipts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('payment_status');
        $table->integer('patient_id')->unsigned();
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('payment_details', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('nhi_amount');
        $table->integer('claim_amount');
        $table->integer('self_amount');
        $table->integer('records_treatment_id')->unsigned();
        $table->foreign('records_treatment_id')->references('id')->on('medical_records_treatments')->onDelete('cascade');
        $table->integer('receipt_id')->unsigned();
        $table->foreign('receipt_id')->references('id')->on('payment_receipts')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('medical_history_items', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('unit');
        $table->timestamps();
      });
      Schema::create('medical_histories', function (Blueprint $table) {
        $table->increments('id');
        $table->string('value');
        $table->text('description')->nullable();
        $table->integer('patient_id')->unsigned();
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        $table->integer('item_id')->unsigned();
        $table->foreign('item_id')->references('id')->on('medical_history_items')->onDelete('cascade');
        $table->timestamps();
      });
      Schema::create('claim_requests', function (Blueprint $table){
        $table->increments('id');
        $table->string('department');
        $table->string('medical_history_number');
        $table->string('read_at')->nullable();
        $table->timestamps();
      });
      Schema::create('claim_responses', function (Blueprint $table){
        $table->increments('id');
        $table->string('id_number');
        $table->bigInteger('deductible_amount');
        $table->bigInteger('copayment_amount');
        $table->bigInteger('covered_amount');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('claim_responses');
        Schema::dropIfExists('claim_requests');
        Schema::dropIfExists('medical_histories');
        Schema::dropIfExists('medical_history_items');
        Schema::dropIfExists('payment_details');
        Schema::dropIfExists('payment_receipts');
        Schema::dropIfExists('medical_records_treatments');
        Schema::dropIfExists('diagnostics');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('treatments');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('treatment_categories');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('patients');
    }
}
