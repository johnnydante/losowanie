<?php
namespace App\Tools;

class Globals
{

    public static function getPolishDate($date) {
        $day = intval(date("d",strtotime($date)));
        $year = date("Y",strtotime($date));
        $intDay = date("w",strtotime($date));
        $intMonth = intval(date("m",strtotime($date)));
        switch($intDay) {
            case 0:
                $dayOfWeek = 'niedziela';
                break;
            case 1:
                $dayOfWeek = 'poniedziałek';
                break;
            case 2:
                $dayOfWeek = 'wtorek';
                break;
            case 3:
                $dayOfWeek = 'środa';
                break;
            case 4:
                $dayOfWeek = 'czwartek';
                break;
            case 5:
                $dayOfWeek = 'piątek';
                break;
            case 6:
                $dayOfWeek = 'sobota';
                break;
        }

        switch($intMonth) {
            case 1:
                $month = 'stycznia';
                break;
            case 2:
                $month = 'lutego';
                break;
            case 3:
                $month = 'marca';
                break;
            case 4:
                $month = 'kwietnia';
                break;
            case 5:
                $month = 'maja';
                break;
            case 6:
                $month = 'czerwca';
                break;
            case 7:
                $month = 'lipca';
                break;
            case 8:
                $month = 'sierpnia';
                break;
            case 9:
                $month = 'września';
                break;
            case 10:
                $month = 'października';
                break;
            case 11:
                $month = 'listopada';
                break;
            case 12:
                $month = 'grudnia';
                break;
        }
        $newDate = $dayOfWeek . ', ' . $day . ' ' . $month . ' ' . $year;
        return $newDate;
    }

    public static function getBirthdayDate($date) {
        $day = intval(date("d",strtotime($date)));
        $intMonth = intval(date("m",strtotime($date)));

        switch($intMonth) {
            case 1:
                $month = 'stycznia';
                break;
            case 2:
                $month = 'lutego';
                break;
            case 3:
                $month = 'marca';
                break;
            case 4:
                $month = 'kwietnia';
                break;
            case 5:
                $month = 'maja';
                break;
            case 6:
                $month = 'czerwca';
                break;
            case 7:
                $month = 'lipca';
                break;
            case 8:
                $month = 'sierpnia';
                break;
            case 9:
                $month = 'września';
                break;
            case 10:
                $month = 'października';
                break;
            case 11:
                $month = 'listopada';
                break;
            case 12:
                $month = 'grudnia';
                break;
        }
        $newDate = $day . ' ' . $month;
        return $newDate;
    }

    public function getDateToDiff($date) {
        $day = date("d",strtotime($date));
        $month = date("m",strtotime($date));
        $year = date('Y');
        return $year.'-'.$month.'-'.$day;
    }

    public function getDayOfWeek($date) {
        $intDay = date("w",strtotime($date));
        switch($intDay) {
            case 0:
                $dayOfWeek = 'niedziela';
                break;
            case 1:
                $dayOfWeek = 'poniedziałek';
                break;
            case 2:
                $dayOfWeek = 'wtorek';
                break;
            case 3:
                $dayOfWeek = 'środa';
                break;
            case 4:
                $dayOfWeek = 'czwartek';
                break;
            case 5:
                $dayOfWeek = 'piątek';
                break;
            case 6:
                $dayOfWeek = 'sobota';
                break;
        }
        return $dayOfWeek;
    }

}
