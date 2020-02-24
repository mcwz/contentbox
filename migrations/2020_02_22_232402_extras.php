<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('key');
            $table->string('default');
            $table->string('validations');
            $table->string('extras');
            $table->unsignedSmallInteger('mustinput')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        $now=date("Y-m-d H:i:s");
        DB::table('extras')->insert(
            ['type' => 'text',
             'name' => '引题',
             'key'=>'yinti',
             'default'=>'',
             'validations'=>'',
             'extras'=>'',
             'mustinput'=>0,
             'created_at'=>$now,
             'updated_at'=>$now]
        );
        DB::table('extras')->insert(
            ['type' => 'text',
             'name' => '副题',
             'key'=>'futi',
             'default'=>'',
             'validations'=>'',
             'extras'=>'',
             'mustinput'=>0,
             'created_at'=>$now,
             'updated_at'=>$now]
        );
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
