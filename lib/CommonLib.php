<?

namespace app\lib;

class CommonLib
{
    public static function getAvatarLetter($name, $id)
    {
        $name = preg_replace('/[^A-Za-zА-Яа-я0-9_-]/u', '', $name);
        $letter = mb_strtolower(mb_substr($name, 0, 1));

        $ind = $id % 16;
        $ruArr = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'yo',  'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'ts',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => 'zn2',  'ы' => 'yy',  'ъ' => 'zn1',
            'э' => 'ee',  'ю' => 'yu',  'я' => 'ya',
        );

        if (in_array($letter, array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'))) {
            return  '/images/icon_en/' . $letter . '/' . $ind . '.png';
        } else if (array_key_exists($letter, $ruArr)) {
            return '/images/icon_ru/' . $ruArr[$letter] . '/' . $ind . '.png';
        } else if (in_array($letter, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_'))) {
            return '/images/icon_number/' . $letter . '/' . $ind . '.png';
        }

        return '/images/icon_number/blank/' . $ind . '.png';
    }

    public static function dateRuFormate($date)
    {
        $monthes = array(
            1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
            5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
            9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
        );
        list($year, $month, $day) = explode('-', substr($date, 0, 10));
        return (int)$day . ' ' . $monthes[(int)$month] . ' ' . $year;
    }

    public static function getPhrase($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }


    public static function showDate($date, $i = 1) // $date --> время в формате Unix time
    {
        $stf      = 0;
        $cur_time = time();
        $diff     = $cur_time - $date;
        if ($diff < 20) return "Только что";
        if ($diff > 60 * 60 * 24 * $i) return self::dateRuFormate(date('Y-m-d', $date));
        $seconds = array('секунда', 'секунды', 'секунд');
        $minutes = array('минута', 'минуты', 'минут');
        $hours   = array('час', 'часа', 'часов');
        $days    = array('день', 'дня', 'дней');
        $weeks   = array('неделя', 'недели', 'недель');
        $months  = array('месяц', 'месяца', 'месяцев');
        $years   = array('год', 'года', 'лет');
        $decades = array('десятилетие', 'десятилетия', 'десятилетий');

        $phrase = array($seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades);
        $length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);

        for ($i = sizeof($length) - 1; ($i >= 0) && (($no = $diff / $length[$i]) <= 1); $i--) {;
        }
        if ($i < 0) {
            $i = 0;
        }
        $_time = $cur_time - ($diff % $length[$i]);
        $no    = floor($no);
        $value = sprintf("%d %s ", $no, self::getPhrase($no, $phrase[$i]));

        return $value . ' назад';
    }

    public static function rus2translit($string)
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'yo',  'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'ts',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '`',   'ы' => 'y',  'ъ' => '``',
            'э' => 'e`',  'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'YO',  'Ж' => 'ZH',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'TS',
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SCH',
            'Ь' => '`',   'Ы' => 'Y',   'Ъ' => '``',
            'Э' => 'E`',  'Ю' => 'YU',  'Я' => 'YA',
        );
        return strtr($string, $converter);
    }
    public static function str2url($str)
    {

        $str = self::rus2translit($str);
        $str = strtolower($str);
        $str = str_replace('`', '', $str);
        $str = preg_replace(array('/[^-a-z0-9_-]+/u', '/-+/'), array('-', '-'), $str);
        $str = trim($str, "-");
        return $str;
    }

    public static function dateRu($str)
    {
        $ruMonths = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
        $enMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $str = str_replace($enMonths, $ruMonths, date($str));
        return $str;
    }
    public static function mb_ucfirst($text)
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_strtolower(mb_substr($text, 1));
    }
}
