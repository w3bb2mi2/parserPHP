<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTitle3 extends Model
{
    protected $table = "_document_title3";
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = ['title', 'Vid_ID', 'docRef_docUUID', 'docRef_presentation', 'creatorRef_agentUUID','creatorRef_presentation', 'creation_time'];
}
