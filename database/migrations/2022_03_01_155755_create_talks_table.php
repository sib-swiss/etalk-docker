<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->id();
            $table->string('dir', 50)->nullable();
            $table->string('title');
            $table->string('author');
            $table->date('date');
            $table->string('theme')->nullable();
            $table->string('duration')->default('');
            $table->string('external_id')->default('');
            $table->boolean('published')->default(false);
        });

        Storage::makeDirectory('public/talks');
        Storage::setVisibility('public/talks', 'public');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talks');
    }
}
