<?php namespace Rainlab\Pages\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTestsTable extends Migration
{
    public function up()
    {
        Schema::create('rainlab_pages_tests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rainlab_pages_tests');
    }
}
