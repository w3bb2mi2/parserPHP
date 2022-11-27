<?php

namespace App\Console\Commands;

use App\Models\DocumentTitle;
use Faker\Provider\zh_TW\DateTime;
use Illuminate\Console\Command;

class AppendDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:append {title}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление документа';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fields = [
            "title" => $this->argument('title'),
            "document_reference" => uniqid(),
            "creator_reference" => uniqid(),
            "creation_time" => date('Y-m-d H:i:s')
        ];
        
        $doc = new DocumentTitle($fields);
        
       // $doc->title = $this->argument('title');
        //$doc->reference_document = uniqid();
        //$doc->creation_time=date('Y-m-d H:i:s');
        //$doc->creator_link = uniqid();

        $doc->save();
        echo 'append new document '.$this->argument('title').' '.$doc->reference_document;
        return 0;
    }
}
