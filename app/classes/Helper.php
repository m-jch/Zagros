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
            'Critical' => '#FF3A3A',
            'High'     => '#990D0D',
            'Medium'   => '#007C1E',
            'Low'      => '#000'
        );

        return $colors[self::getBlueprintImportance($index)];
    }

    public static function getBlueprintStatus($index = null)
    {
        $blueprintsStatus = array(
            0 => 'Not Started',
            1 => 'On Hold',
            2 => 'Started',
            3 => 'In Proggress',
            4 => 'Good Progress',
            5 => 'Beta Available',
            6 => 'Implemented',
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
            'Not Started'    => '#414141',
            'Started'        => '#002847',
            'In Proggress'   => '#00467E',
            'Good Progress'  => '#0B79D1',
            'Beta Available' => '#888302',
            'Implemented'    => '#007E00',
            'On Hold'        => '#000',
            'Rejected'       => '#8A8A8A',
            'Unknown'        => '#8A8A8A'
        );

        return $colors[self::getBlueprintStatus($index)];
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
