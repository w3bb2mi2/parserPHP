<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_title', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->require();
            $table->string('Vid_ID')->require();
            $table->string('docRef_docUUID')->require();
            $table->string('docRef_presentation')->require();
            $table->string('creatorRef_agentUUID')->require();
            $table->string('creatorRef_presentation')->require();
            $table->string('creation_time')->require();
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
