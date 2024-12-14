<?php

$cfg['ServerDefaultCharset'] = 'utf8mb4';
$cfg['DefaultConnectionCollation'] = 'utf8mb4_unicode_ci';

$i = 0;
$i++;
if(getenv("PMA_NO_PASSWORD") == 1){
    $cfg['Servers'][$i]['AllowNoPassword'] = true;
}
else{
    $cfg['Servers'][$i]['AllowNoPassword'] = false;
}

# Config

