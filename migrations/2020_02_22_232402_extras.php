<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Sheld\Contentbox\Extra;

class Extras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('name');
            $table->string('varkey');
            $table->string('default');
            $table->string('validations');
            $table->json('extras');
            $table->unsignedSmallInteger('mustinput')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Extra::create(['type' => 'text',
        'name' => '引题',
        'varkey'=>'yinti',
        'default'=>'',
        'validations'=>'',
        'extras'=>'{}',
        'mustinput'=>0]);
        Extra::create(['type' => 'text',
        'name' => '副题',
        'varkey'=>'futi',
        'default'=>'',
        'validations'=>'',
        'extras'=>'{}',
        'mustinput'=>0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extras');
    }
}
