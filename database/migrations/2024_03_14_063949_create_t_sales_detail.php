<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSalesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_sales_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('t_sales_id')
                  ->comment('Fill with id of t_sales');
            $table->integer('m_product_id')
                  ->comment('Fill with id of m_product')
                  ->nullable();
            $table->integer('m_product_detail_id')
                  ->comment('Fill with id of m_product_detail')
                  ->nullable();
            $table->integer('total_item')
                  ->default(0);
            $table->double('price')
                  ->default(0);
            $table->double('discount_nominal')
                  ->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->index('t_sales_id');
            $table->index('m_product_id');
            $table->index('m_product_detail_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_sales_detail');
    }
}
