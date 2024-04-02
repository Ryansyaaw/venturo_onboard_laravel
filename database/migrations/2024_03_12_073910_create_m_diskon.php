<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDiskon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_diskon', function (Blueprint $table) {
            $table->id();
            $table->string('m_customer_id')
                    ->comment('Fill with id of m_customer');
            $table->bigInteger('m_promo_id')
                    ->comment('Fill with id of m_promo');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);

            $table->index('m_customer_id');
            $table->index('m_promo_id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_diskon');
    }
}
