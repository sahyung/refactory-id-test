<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name')->nullable();
            $table->bigInteger('min')->nullable();
            $table->bigInteger('max')->nullable();
            $table->integer('disc_rate')->nullable()->comment('percentage of the discount for this tier');
            $table->integer('disc_prob')->nullable()->comment('percentage of the probability getting the discount');
            $table->softDeletes();
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
        Schema::dropIfExists('tiers');
    }
}
