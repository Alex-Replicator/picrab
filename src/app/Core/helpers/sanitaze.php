<?php

function sanitaze($string){
    $string = filter_var(
        $string,
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
    $string = htmlspecialchars($string);
    return $string;
}