<?php

declare(strict_types=1);

namespace App\Service\Parser;

use App\Service\XmlNamespace;
use App\Service\XmlReader;
use App\Service\Parser\DocumentParserInterface;

/**
 * Class DocumentTitleParser
 */
class DocumentTitleParser extends EntityXmlParser implements DocumentParserInterface
{
    /**
     * @param \DOMElement $root
     *
     * @return array
     */
    public function parse($root): array
    {

        $fields = [
            "title"=>[XmlReader::ATTR=>'doc:ВидНазвание'],
            "document_reference"=>[XmlReader::QUERY=>'cdm:СсылкаДокумента', XmlReader::ATTR=>'cdm:ДокументУУИД'],
            "document_presentation"=>[XmlReader::QUERY=>'cdm:СсылкаДокумента', XmlReader::ATTR=>'cdm:Представление'],
            "creator_reference"=>[XmlReader::QUERY=>'cdm:СсылкаСоздателя', XmlReader::ATTR=>'cdm:АгентУУИД'],
            "creator_presentation"=>[XmlReader::QUERY=>'cdm:СсылкаСоздателя', XmlReader::ATTR=>'cdm:Представление'],
            "creation_time"=>[XmlReader::QUERY=>'cdm:ВремяСоздания'],
        ];

        $aProp = $this->xmlReader->extractValues($fields, $root);

        return $aProp;
    }
    
	/**
	 * @return array
	 */
	public function namespaces(): array
  {
    return [new XmlNamespace("pre","name")];
	}

}
