<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_customer', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100)
                    ->comment('Fill with name of customer');
            $table->string('email', 50)
                    ->default(null)
                    ->comment('Fill with email of customer');
            $table->string('photo', 100)
                    ->comment('Fill with customer profile picture')
                    ->default(null)
                    ->nullable();
            $table->string('phone_number', 25)
                    ->default(null)
                    ->comment('Fill with phone number of user')
                    ->nullable();
            $table->date('date_of_birth')
                    ->default(null)
                    ->comment('fill with date of birth of customer')
                    ->nullable();
            $table->tinyInteger('is_verifyed')
                    ->default(0)
                    ->comment('fill with "1" if customer is verifyed. fill with "0" if customer is not verifyed');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);

            $table->index('email');
            $table->index('name');
            $table->index('is_verifyed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_customer');
    }
}
