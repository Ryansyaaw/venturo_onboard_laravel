<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_promo', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->comment('Fill with name of promo');
            $table->enum('status', ['voucher', 'diskon'])->comment('Fill with type of promo');
            $table->integer('expired_in_day')->comment('Fill with total of active day, Fill with 1 for 1 day, 7 for 1 week, and 30 for 1 month');
            $table->double('nominal_percentage')
                  ->comment('fill when status = diskon')
                  ->nullable()
                  ->default(null);
            $table->double('nominal_rupiah')
                  ->comment('fill when status = voucher')
                  ->nullable()
                  ->default(null);
            $table->text('term_conditions')
                  ->comment('Fill with term and conditions to get this promo');
            $table->text('photo')
                  ->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_promo');
    }
}
