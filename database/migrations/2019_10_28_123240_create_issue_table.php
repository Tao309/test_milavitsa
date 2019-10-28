<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->text('message')->nullable();
            $table->text('file')->nullable();
            $table->text('answer')->nullable();
            $table->smallInteger('inwork')->default(0);
            $table->smallInteger('closed')->default(0);
            $table->bigInteger('author_id')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue');
    }
}
