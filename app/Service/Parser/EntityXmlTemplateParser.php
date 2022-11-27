<?php

declare(strict_types=1);

namespace App\Service\Parser;

use DOMElement;
use App\Service\Parser\DocumentParserInterface;

/**
 * Class EntityXmlTemplateParser 
 * шаблон парсера
 */
class EntityXmlTemplateParser extends EntityXmlParser implements DocumentParserInterface
{
    /**
     * @param DOMElement $root
     *
     * @return array
     */
    public function parse($root): array
    {

        // вариант 1

        define("_query","query");
        define("_attr","attr");

        $fields = [
            "title"=>[_attr=>'doc:ВидНазвание'],
            "document_reference"=>[_query=>'cdm:СсылкаДокумента', _attr=>'cdm:ДокументУУИД'],
            "document_presentation"=>[_query=>'cdm:СсылкаДокумента', _attr=>'cdm:Представление'],
            "creator_reference"=>[_query=>'cdm:СсылкаСоздателя', _attr=>'cdm:АгентУУИД'],
            "creator_presentation"=>[_query=>'cdm:СсылкаСоздателя', _attr=>'cdm:Представление'],
            "creation_time"=>[_query=>'cdm:ВремяСоздания'],
        ];


        $aProp = $this->xmlReader->extractValues($fields, $root);

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
