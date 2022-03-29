<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sounds', function (Blueprint $table) {
            $table->string('id');
            $table->string('dir');
            $table->text('text');
            $table->enum('type', ['explanation', 'quotation'])->default('explanation');
            $table->string('entities');
            $table->string('file');
            $table->string('file_credits')->default('Creative Commons Attribution - Pas dâ€™Utilisation Commerciale - Partage dans les MÃªmes Conditions 3.0 Suisse');
            $table->string('file_link')->default('http://creativecommons.org/licenses/by-nc-sa/3.0/ch/deed.fr');
            $table->enum('chaptering', ['continue', 'paragraph', 'section'])->default('continue');
            $table->string('section_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sounds');
    }
}
