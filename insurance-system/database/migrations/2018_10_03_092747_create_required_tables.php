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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->timestamps();
        });
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('max_claimable_amount');
            $table->timestamps();
        });
        Schema::create('claimables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('amount');
            $table->string('max_count');
            $table->timestamps();
        });
        Schema::create('insurance_policies_hospitals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospital_id')->unsigned();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->integer('insurance_policy_id')->unsigned();
            $table->foreign('insurance_policy_id')->references('id')->on('insurance_policies')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('insurance_policies_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('insurance_policy_id')->unsigned();
            $table->foreign('insurance_policy_id')->references('id')->on('insurance_policies')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('claim_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('In Review');
            $table->dateTime('read_at_app')->nullable();
            $table->dateTime('read_at_system')->nullable();
            $table->string('hospital_department');
            $table->string('medical_history_number');
            $table->integer('hospital_id')->unsigned();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('insurance_policy_id')->unsigned();
            $table->foreign('insurance_policy_id')->references('id')->on('insurance_policies')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('claim_requests_claimables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount'); // approved amount
            $table->integer('claimable_id')->unsigned();
            $table->foreign('claimable_id')->references('id')->on('claimables')->onDelete('cascade');
            $table->integer('claim_request_id')->unsigned();
            $table->foreign('claim_request_id')->references('id')->on('claim_requests')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('insurance_policies_claimables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('claimable_id')->unsigned();
            $table->foreign('claimable_id')->references('id')->on('claimables')->onDelete('cascade');
            $table->integer('insurance_policy_id')->unsigned();
            $table->foreign('insurance_policy_id')->references('id')->on('insurance_policies')->onDelete('cascade');
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
        Schema::dropIfExists('insurance_policies_claimables');
        Schema::dropIfExists('claim_requests_claimables');
        Schema::dropIfExists('claim_requests');
        Schema::dropIfExists('insurance_policies_users');
        Schema::dropIfExists('insurance_policies_hospitals');
        Schema::dropIfExists('claimables');
        Schema::dropIfExists('insurance_policies');
        Schema::dropIfExists('hospitals');
    }
}
