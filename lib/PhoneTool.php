<?

namespace app\lib;

class PhoneTool
{

	public static function phoneIn($str)
	{
		$str = preg_replace('/[^0-9]/', '', $str);
		return mb_substr($str, -10);
	}

	public static function forUrl($str)
	{
		$sub = substr($str, 0, 3);
		if ($sub == 800) $number = '8';
		else $number = '7';
		return $number . $str;
	}

	public static function formated($str)
	{
		$phone = '';
		$sub = substr($str, 0, 3);
		if ($sub == 800) $phone .= '8';
		else $phone .= '7';
		$phone .= $str;
		$number = (string)$phone;
		$numberFormat =  $number[0] . '(' . $number[1] . $number[2] . $number[3] . ')' . $number[4] . $number[5] . $number[6] . '-' . $number[7] . $number[8] . '-' . $number[9] . $number[10];
		if ($sub != 800) $numberFormat = '+' . $numberFormat;
		return $numberFormat;
	}
}
