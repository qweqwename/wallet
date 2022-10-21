<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',16,2 );
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->unsignedTinyInteger('status')->default(1);
            $table->text('message')->nullable();
            $table->decimal('fee',16,2 );
            $table->timestamps();

            $table->index(['from', 'to']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
