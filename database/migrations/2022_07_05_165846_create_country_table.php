<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->integer('json_id');
            $table->string('name');
            $table->string('iso3');
            $table->string('iso2');
            $table->string('numeric_code');
            $table->string('phone_code');
            $table->string('capital');
            $table->string('currency');
            $table->string('currency_symbol');
            $table->string('tld');
            $table->string('native');
            $table->string('region');
            $table->string('subregion');
            $table->json('timezones');
            $table->json('translations');
            $table->json('languages');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('emoji');
            $table->string('emojiU');
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
        Schema::dropIfExists('countries');
    }
}
