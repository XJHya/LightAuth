<?php
function encrypt($string, $salt)
{
    $saltedString = $string . $salt;
    return hash('sha256', $saltedString);
}
