<?php

class Helper
{
    public static function slugify($text)
    {
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
      $text = trim($text, '-');
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = strtolower($text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      if (empty($text))
      {
        return false;
      }
      return $text;
    }
}
