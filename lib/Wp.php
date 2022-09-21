<?

namespace app\lib;

use yii\web\UrlRuleInterface;

class Wp implements UrlRuleInterface
{
	public $connectionID = 'wp';

	public function createUrl($manager, $route, $params)
	{
		if ($route === 'forum/show') {
			if (isset($params['id']) && isset($params['title'])) {
				return '/' . \app\lib\CommonLib::str2url($params['title']) . '-' . $params['id'];
			}
		} else if ($route === 'forum/tag') {
			if (isset($params['regionLink']) && isset($params['tagLink'])) {
				return '/' . $params['regionLink'] . '/' . $params['tagLink'];
			}
		}
		if ($route === 'phone/index') {
			if (isset($params['number'])) {
				return '/' . $params['number'];
			}
		}
		return false;
	}

	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();

		if (preg_match('/-([0-9]+)$/si', $pathInfo, $m)) {
			return ['forum/show', ['forum_id' => $m[1]]];
		}
		return false;
	}
	/*
	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
	{
		if (defined('IS_ODMIN')) return false;

		if (preg_match('/-([0-9]+)$/si', $rawPathInfo, $m)) {
			return 'forum/show/forum_id/' . $m[1];
		}
		if (preg_match('/^([0-9]+)$/si', $rawPathInfo, $m)) {
			return 'phone/info/number/' . $m[1];
		}

		$paths = explode('/', $rawPathInfo);
		if (count($paths) == 2) {
			$linkTag = $paths[count($paths) - 1];
			$tag = ForumTag::model()->find('link=:link', array('link' => $linkTag));
			$tagId = 0;
			if ($tag != null) {
				$tagId = $tag->id;
				$linkRegion = $paths[0];

				$city = City::model()->find('t.link=:link', array('link' => $linkRegion));
				if ($city != null) return 'forum/tag/tagId/' . $tag->id . '/cityId/' . $city->id;
				$region = Region::model()->find('t.link=:link', array('link' => $linkRegion));
				if ($region != null) return 'forum/tag/tagId/' . $tag->id . '/regionId/' . $region->id;
				$country = Country::model()->find('t.link=:link', array('link' => $linkRegion));
				if ($country != null) return 'forum/tag/tagId/' . $tag->id . '/countryId/' . $country->id;
			}
		} else if (count($paths) == 1) {
			$linkRegion = $paths[0];
			$city = City::model()->find('t.link=:link', array('link' => $linkRegion));
			if ($city != null) return 'forum/index/cityId/' . $city->id;
			$region = Region::model()->find('t.link=:link', array('link' => $linkRegion));
			if ($region != null) return 'forum/index/regionId/' . $region->id;
			$country = Country::model()->find('t.link=:link', array('link' => $linkRegion));
			if ($country != null) return 'forum/index/countryId/' . $country->id;
		}

		return false;  // this rule does not apply
	}
	*/
}
