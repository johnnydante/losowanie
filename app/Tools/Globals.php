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
        if(date('m-d', strtotime($date)) < date('m-d')) {
            $year += 1;
        }
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

    public function getColorForBirthday($birthday) {
        $color = '#007b00';
        if(date_diff(date_create($this->getDateToDiff($birthday)),date_create(date('Y-m-d')))->days < 30
            AND $this->getDateToDiff($birthday) >= date('Y-m-d')) {
            $color = '#ee0600';
        } elseif(date_diff(date_create($this->getDateToDiff($birthday)),date_create(date('Y-m-d')))->days < 90
            AND $this->getDateToDiff($birthday) >= date('Y-m-d')) {
            $color = '#a500a5';
        } elseif(date_diff(date_create($this->getDateToDiff($birthday)),date_create(date('Y-m-d')))->days < 180
            AND $this->getDateToDiff($birthday) >= date('Y-m-d')) {
            $color = '#0000da';
        }
        return $color;
    }

    public function isMobile() {
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            return true;
        }
        return false;
    }

    public function getChildrenAge($date) {
        $birthdayYear = substr($date, 0, 4);
        $nextBirthdayYear = date("Y");
        if(\Globals::getDateToDiff($date) < date('Y-m-d')) {
            $nextBirthdayYear = date("Y") + 1;
        }
        if(date('Y', strtotime(\Globals::getDateToDiff($date))) > date('Y')) {
            $nextBirthdayYear = date("Y") + 1;
        }
        $age = $nextBirthdayYear - $birthdayYear;
        switch ($age) {
            case 1:
                $string = ' roczek';
                break;
            case 2:
                $string = ' lata';
                break;
            case 3:
                $string = ' lata';
                break;
            case 4:
                $string = ' lata';
                break;
            default:
                $string = ' lat';
                break;
        }

        return '('.$age.$string.')';
    }
}
