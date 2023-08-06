<?php
function generateRandomString($length = 10): string
{
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
echo PHP_EOL;
echo generateRandomString(64);
echo PHP_EOL;
