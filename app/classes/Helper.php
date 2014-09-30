<?php

class Helper
{

    public static function getBlueprintsImportance()
    {
        return array(
            0 => 'Critical',
            1 => 'High',
            2 => 'Medium',
            3 => 'Low',
        );
    }

    public static function getBlueprintsStatus()
    {
        return array(
            0 => 'Not Started',
            1 => 'Started',
            2 => 'In Proggress',
            3 => 'Good Progress',
            5 => 'Beta Available',
            6 => 'Implemented',
            4 => 'On Hold',
            7 => 'Rejected',
            8 => 'Unknown'
        );
    }

    public static function getBlueprintStatusColor($blueprint)
    {
        return $colors[$blueprint];

        $colors = array(
            'Not started' => '#eec',
        );
    }

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
