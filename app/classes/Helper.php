<?php

class Helper
{

    public static function getBlueprintImportance($index = null)
    {
        $blueprintImportance = array(
            0 => 'Critical',
            1 => 'High',
            2 => 'Medium',
            3 => 'Low',
        );

        if (is_null($index))
            return $blueprintImportance;
        else
            return $blueprintImportance[$index];
    }

    public static function getBlueprintImportanceColor($index)
    {
        $colors = array(
            0 => '#FF3A3A',
            1 => '#990D0D',
            2 => '#007C1E',
            3 => '#000'
        );

        return $colors[$index];
    }

    public static function getBlueprintStatus($index = null)
    {
        $blueprintsStatus = array(
            0 => 'Not Started',
            1 => 'Started',
            2 => 'In Proggress',
            3 => 'Good Progress',
            4 => 'Beta Available',
            5 => 'Implemented',
            6 => 'On Hold',
            7 => 'Rejected',
            8 => 'Unknown'
        );

        if (is_null($index))
            return $blueprintsStatus;
        else
            return $blueprintsStatus[$index];

    }

    public static function getBlueprintStatusColor($index)
    {
        $colors = array(
            0 => '#414141',
            1 => '#002847',
            2 => '#00467E',
            3 => '#0B79D1',
            4 => '#888302',
            5 => '#007E00',
            6 => '#000',
            7 => '#8A8A8A',
            8 => '#8A8A8A'
        );

        return $colors[$index];
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
