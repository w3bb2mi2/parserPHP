<?php

namespace App\Console\Commands;
use App\Service\Parser\ProcessInformationParser;
use App\Service\XmlNamespace;
use DOMElement;
use App\Service\Parser\DocumentTitleParser;
use Illuminate\Console\Command;
use App\Models\DocumentTitle;
use App\Service\XmlContainer;
use App\Service\XmlReader;
use App\Service\Parser\EntityXmlParser;
use Symfony\Component\VarDumper\VarDumper;

class ProcessXmlContainerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'container:process {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обрабытывает указанный контейнер';

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
        echo 'Обрабатывается '.$this->argument('file').PHP_EOL;
//TODO: в класс ContainerProcessor
        // конвертируем, если файл в неопознанной кодировке
        $xmlString = iconv('UTF-8', 'UTF-8//IGNORE', file_get_contents('./tests/Resources/'.$this->argument('file')));
        

        $xml = new XmlReader();
        //var_dump(preg_replace('/\sxmlns="(.*?)"/', '', $xml));
        $xml->loadXml($xmlString);
        //print_r( $xml->dom->saveXML() );

        
        $root = $xml->getXpath()->document->documentElement;
        
        $parser = new DocumentTitleParser($xml);
        $node = $xml->getNode('doc:ДанныеДокумента/doc:ЗаголовокДокумента', $root);
        $fld = $parser->parse($node);
        echo 'Сформирован документ'.PHP_EOL;
        var_dump($fld);

        echo PHP_EOL.'Сообщения Документа'.PHP_EOL;
        $parser = new ProcessInformationParser($xml);
        /** @var XmlNamespace $ns */
        foreach ($parser->namespaces() as $ns) {
            $xml->getXpath()->registerNamespace($ns->prefix, $ns->namespace);
        }
//TODO: обрабатывать дочерние узлы, без привязки к конкретному событию ака exc005:ВыдачаПоручения
        $eventNode = $xml->getNode('doc:ДанныеДокумента/doc:СообщенияДокумента', $root);
        $events = $xml->getNodes('exc005:ВыдачаПоручения',$eventNode);
        foreach ($events as $n) 
        {
            echo '<'.$n->tagName.'>'.PHP_EOL;
            $eventInfo=$xml->getNode('exc005:ИнформацияОПроцессе', $n);
            $fld = $parser->parse($eventInfo);
            var_dump($fld);
            echo PHP_EOL;
        }        

        /*
        
        //var_dump($model);
        //$doc->save();
*/
        echo PHP_EOL.'Добавлен новый документ '.$this->argument('file').PHP_EOL;
        return 0;
    }
}
