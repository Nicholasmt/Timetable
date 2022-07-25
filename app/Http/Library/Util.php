<?php
  namespace App\Http\Library;


  use Carbon\Carbon;
  use DB;

  class Util
  {
    public $semester;
    public $table_type;
    public $table_model;

    static function week_day(int $num)
    {
        $day="";
        switch($num){
            case 0:
                $day="Sun";
             break;
             case 1:
                $day="Mon";
             break;
             case 2:
                $day="Tue";
             break;
             case 3:
                $day="Wed";
             break;
             case 4:
                $day="Thu";
             break;
             case 5:
                $day="Fri";
             break;
             case 6:
                $day="Sat";
             break;
             default:
                $day="Unknown";
             break;

        }
        return $day;
    }

  }

?>
