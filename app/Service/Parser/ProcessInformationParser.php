<?php

declare(strict_types=1);

namespace App\Service\Parser;

use App\Service\XmlReader;
use App\Service\XmlNamespace;
use App\Service\Parser\DocumentParserInterface;

/**
 * Class ProcessInformationParser 
 * Парсер Информации о процессе
 */
class ProcessInformationParser extends EntityXmlParser implements DocumentParserInterface
{
    /**
     * @param \DOMElement $root
     *
     * @return array
     */
    public function parse($root): array
    {

      $fields = [
          "title"=>[XmlReader::ATTR=>'exc005:ВидНазвание'],
          "process_reference"=>[XmlReader::QUERY=>'cdm:СсылкаПроцесса', XmlReader::ATTR=>'cdm:ПроцессУУИД'],
          "process_presentation"=>[XmlReader::QUERY=>'cdm:СсылкаПроцесса', XmlReader::ATTR=>'cdm:Представление'],
          "creator_reference"=>[XmlReader::QUERY=>'cdm:СсылкаСоздателя', XmlReader::ATTR=>'cdm:АгентУУИД'],
          "creator_presentation"=>[XmlReader::QUERY=>'cdm:СсылкаСоздателя', XmlReader::ATTR=>'cdm:Представление'],
          "creation_time"=>[XmlReader::QUERY=>'cdm:ВремяСоздания']
      ];

      $aProp = $this->xmlReader->extractValues($fields, $root);
        
        return $aProp;
    }

	/**
	 * @return array
	 */
	public function namespaces(): array
  {
    return [new XmlNamespace("exc005","urn:Exc01-005-00001:ExchangeMeta:v0.2.3")];
	}
}
