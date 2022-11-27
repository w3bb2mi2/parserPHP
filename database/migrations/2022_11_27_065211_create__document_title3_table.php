<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTitle3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_document_title3', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->string('Vid_ID');
            $table->string('docRef_docUUID');
            $table->string('docRef_presentation');
            $table->string('creatorRef_agentUUID');
            $table->string('creatorRef_presentation');
            $table->dateTime('creation_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_document_title3');
    }
}
