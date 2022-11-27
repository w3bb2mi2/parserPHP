<?php

namespace App\Service\Parser2;

use DOMDocument;
use XMLReader;

class Parser
{

    static function index()
    {
        $reader = new XMLReader();
        $reader->open('http://resources/digital.xml'); // указываем ридеру что будем парсить этот файл
        //циклическое чтение документа
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                // если находим элемент <card>
                dump($reader);
                if ($reader->localName == 'ЗаголовокДокумента') {
                    $data = array();
                    // считываем аттрибут number
                    $data['title'] = $reader->getAttribute('doc:ВидНазвание');
                    // читаем дальше для получения текстового элемента
                    dd($data);
                    $reader->read();
                    if ($reader->nodeType == XMLReader::TEXT) {
                        $data['name'] = $reader->value;
                    }

                    
                    // ну и запихиваем в бд, используя методы нашего адаптера к субд
                    // SomeDataBaseAdapter::insertContact($data);
                }
            }
        }
        //$data = $reader->getAttribute("doc:ЗаголовокДокумента");
        $data = $reader->attributeCount;
        dd($data);
    }
}
