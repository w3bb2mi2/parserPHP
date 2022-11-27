<?php

namespace App\Http\Controllers;

use App\Service\Parser2\Parser;
use Illuminate\Http\Request;

class ParseController extends Controller
{
    public function index(){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__."\\temp\\".$_FILES["file"]["name"]) ){
            echo "Файл успешно загружен";
        }else{
            echo "Произошла ошибка";
        }

        $data = Parser::save2Db(__DIR__."\\temp\\".$_FILES["file"]["name"]);
        

        return redirect()->route("success", $data);
        
    }
}
