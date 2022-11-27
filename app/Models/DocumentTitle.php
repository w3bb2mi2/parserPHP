<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTitle extends Model
{
    protected $table = "document_title";
    use HasFactory;
    protected $guarded = [];
    //protected $fillable = ['title', 'Vid_ID', 'docRef_docUUID', 'docRef_presentation', 'creatorRef_agentUUID','creatorRef_presentation', 'creation_time'];
}
