<?php

namespace App\Http\Controllers;

use App\Service\Parser2\Parser;
use Illuminate\Http\Request;

class ParseController extends Controller
{
    public function index(){
        //$path = __DIR__."\\temp\\".$_FILES["file"]["name"]; //windowsOS
        $path = __DIR__."/".'temp/'.$_FILES["file"]["name"];
        
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $path) ){
            echo "Файл успешно загружен";
        }else{
            echo "Произошла ошибка";
        }

        $data = Parser::save2Db($path);
        

        return redirect()->route("success", $data);
        
    }
}
