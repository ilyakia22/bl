<?

namespace app\lib;

class PhoneTool
{

	public static function phoneIn($str)
	{
		$str = preg_replace('/[^0-9]/', '', $str);
		return mb_substr($str, -10);
	}

	static public function infoAdd($number, $organization_id, $name = null)
	{
	}
}
