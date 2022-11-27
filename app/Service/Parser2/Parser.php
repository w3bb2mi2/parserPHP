<?php

namespace App\Service\Parser2;

use App\Models\DocumentTitle;
use App\Models\ProcessInformation;
use DOMDocument;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use XMLReader;

class Parser
{

    static function index($url)
    {
        $reader = new XMLReader();
        $reader->open($url); // указываем ридеру что будем парсить этот файл
        $data = [];
        $data = array();
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                if ($reader->localName == 'ЗаголовокДокумента' && $reader->depth == 2) {
                    $data["head"]['title'] = $reader->getAttribute('doc:ВидНазвание');
                    $data["head"]['Vid_ID'] = $reader->getAttribute('doc:ВидИД');
                }
                if ($reader->localName == 'СсылкаДокумента') {
                    $data["head"]['docRef_docUUID'] = $reader->getAttribute('cdm:ДокументУУИД');
                    $data["head"]['docRef_presentation'] = $reader->getAttribute('cdm:Представление');
                }
                if ($reader->localName == 'СсылкаСоздателя') {
                    $data["head"]['creatorRef_agentUUID'] = $reader->getAttribute('cdm:АгентУУИД');
                    $data["head"]['creatorRef_presentation'] = $reader->getAttribute('cdm:Представление');
                }
                if ($reader->localName == 'ВремяСоздания') {
                    $reader->read();
                    if ($reader->depth == 4) {
                        $data["head"]['creation_time'] = $reader->value;;
                        // $data["head"]['depth'] = $reader->depth;
                    }
                }


                if ($reader->localName == 'СообщенияДокумента') {
                    $reader->read();
                    while ($reader->read()) {
                        if ($reader->localName == 'ИнформацияОПроцессе') {
                            $data["process_information"]['title'] = $reader->getAttribute('exc005:ВидНазвание');
                            $data["process_information"]['VidID'] = $reader->getAttribute('exc005:ВидИД');
                        }
                        if ($reader->localName == 'СсылкаПроцесса') {
                            $data["process_information"]['eventRef_eventUUID'] = $reader->getAttribute('cdm:ПроцессУУИД');
                            $data["process_information"]['eventRef_presentation'] = $reader->getAttribute('cdm:Представление');
                        }
                        if ($reader->localName == 'СсылкаСоздателя') {
                            $data["process_information"]['creatorRef_agentUUID'] = $reader->getAttribute('cdm:АгентУУИД');
                            $data["process_information"]['creatorRef_presentation'] = $reader->getAttribute('cdm:Представление');
                        }
                        if ($reader->localName == 'ВремяСоздания') {
                            $reader->read();
                            if ($reader->depth == 6) {
                                $data["process_information"]['creation_time'] = $reader->value;;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    static function save2Db($url)
    {
        try {
            $data = Parser::index($url);

            echo "Запрос к базе";
            dd($data);
            $head = new DocumentTitle();
            $head->create($data["head"]);

            $process_information = new ProcessInformation();
            $process_information->create($data["process_information"]);

            return $data;

        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
    }
}
