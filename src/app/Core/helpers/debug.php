<?php

function __dd($var, $array = false){
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($array){
        print_r($var);
    }else{
        var_dump($var);
    }
    echo "</pre></div>";
}

function __ddd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function __d($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

function __pe($msg, $exception = false){
    ob_start();
    echo "<div style='background: #f5f5f5; border: 1px solid #ccc; padding: 10px;'><pre>";
    if($exception) throw new Exception($msg);
    echo $msg;
    echo "</pre></div>";
    return ob_get_clean();
}