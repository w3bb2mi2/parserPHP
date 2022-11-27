<?php

declare(strict_types=1);

namespace App\Service\Parser;

use App\Models\DocumentTitle;
use App\Service\DocumentInterface;
use App\Service\XmlLoaderTrait;
use App\Service\DocumentParserInterface;

/**
 * Class EntityParserTemplate 
 * шаблон парсера
 */
class ProcessInformationParser implements DocumentParserInterface
{
    use XmlLoaderTrait;

    /**
     * @var XmlReader
     */
    private $reader;

    /**
     * @var DOMElement
     */
    private $rootNode;


    /**
     * Parse document.
     *
     * @param mixed $value
     * @return array
     */
    public function parse($value): array
    {

        $xml = $this->reader = $this->load($value);
        $this->rootNode = $xml->getXpath()->document->documentElement;

        // вариант 1

        define("_query","query");
        define("_attr","attr");

        $pre="doc:ДанныеДокумента/doc:ЗаголовокДокумента";
        $fields = [
            "title"=>[_query=>$pre, _attr=>'doc:ВидНазвание'],
            "reference_document"=>[_query=>$pre.'/cdm:СсылкаДокумента', _attr=>'cdm:ДокументУУИД'],
            "presentation_document"=>[_query=>$pre.'/cdm:СсылкаДокумента', _attr=>'cdm:Представление'],
            "creator_link"=>[_query=>$pre.'/cdm:СсылкаСоздателя', _attr=>'cdm:АгентУУИД'],
            "creator_presentation"=>[_query=>$pre.'/cdm:СсылкаСоздателя', _attr=>'cdm:Представление'],
            "creation_time"=>[_query=>$pre.'/cdm:ВремяСоздания'],
        ];

        $aProp = $xml->extractValues($fields, $this->rootNode);

        // вариант 2
        /*
        $aProp = array();

        $node = $xml->getNode('doc:ДанныеДокумента/doc:ЗаголовокДокумента', $this->rootNode);
        $aProp["title"]=$node->getAttribute('doc:ВидНазвание');

        $aProp["reference_document"] = 
          $xml->getNode('cdm:СсылкаДокумента', $node)->getAttribute('cdm:ДокументУУИД');

        $aProp["presentation_document"] = 
          $xml->getNode('cdm:СсылкаДокумента', $node)->getAttribute('cdm:Представление');
    
        $aProp["creator_link"] =
          $xml->getNode('cdm:СсылкаСоздателя', $node)->getAttribute('cdm:АгентУУИД');
        
        $aProp["creator_presentation"] =
          $xml->getAttribute('cdm:СсылкаСоздателя','cdm:Представление', $node);

        $aProp["creation_time"] =
          $xml->getValue('cdm:ВремяСоздания', $node);
        */
        
        return $aProp;
    }

}
