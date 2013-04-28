<?php

/** @title	shorten_string(string, max_length)
  * @desc	shortens a string after $max characters and
  *		appends dots when fill_with_dots is true
  * @return	string
  **/

function shorten_string($str, $max_length)
{
    if (strlen($str) <= $max_length)
        return $str;

    $shorten_by = strlen($str) - $max_length;
    if ($shorten_by < 3)
        $max_length -= $shorten_by;

    $str = substr($str, 0, $max_length);
    $str .= "...";

    return $str;
}

?>

