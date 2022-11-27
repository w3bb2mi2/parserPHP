<?php

namespace App\Service\Parser2;

use App\Models\DocumentTitle3;
use DOMDocument;
use XMLReader;

class Parser
{

    static function index()
    {
        $reader = new XMLReader();
        $reader->open('http://resources/digital1.xml'); // указываем ридеру что будем парсить этот файл
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
                    if ($reader->depth == 4){
                        $data["head"]['creation_time'] = $reader->value;                         ;
                        // $data["head"]['depth'] = $reader->depth;
                    }
                }                
            }
        }
        // dd($data["head"]);
        return $data["head"];
       
    }
    static function save2Db(){
        $data = Parser::index();
        $saver = new DocumentTitle3();
        $saver->create($data);
        $saver->save();
        dd("save to DB");

    }
}


