<?

namespace app\lib;

use yii\web\UrlRuleInterface;

class Wp implements UrlRuleInterface
{
	public $connectionID = 'wp';

	public function createUrl($manager, $route, $params)
	{
		if ($route === 'phone/info' && isset($params['number'])) {
			return '/' . $params['number'];
		} else if ($route === 'organization/info' && isset($params['inn'])) {
			return '/inn' . $params['inn'];
		} else if ($route === 'forum/show') {
			if (isset($params['id']) && isset($params['title'])) {
				return '/' . \app\lib\CommonLib::str2url($params['title']) . '-' . $params['id'];
			}
		} else if ($route === 'forum/tag') {
			if (isset($params['regionLink']) && isset($params['tagLink'])) {
				return '/' . $params['regionLink'] . '/' . $params['tagLink'];
			}
		} else if ($route === 'phone/index') {
			if (isset($params['number'])) {
				return '/' . $params['number'];
			}
		} else if ($route === 'forum/city') {
			if (isset($params['link'])) {
				return '/' . $params['link'] . (isset($params['page']) ? '?page=' . $params['page'] : '');
			}
		}
		return false;
	}

	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();
		if (preg_match('/^inn([0-9]+)$/si', $pathInfo, $m)) {
			return ['organization/info', ['inn' => $m[1]]];
		} else if (preg_match('/-([0-9]+)$/si', $pathInfo, $m)) {
			return ['forum/show', ['forum_id' => $m[1]]];
		} else if (preg_match('/^[0-9]{11}+$/si', $pathInfo, $m)) {
			return ['phone/info', ['number' => $pathInfo]];
		}

		$paths = explode('/', $pathInfo);
		if (count($paths) == 2) {
			$linkTag = $paths[count($paths) - 1];
			$tag = (new \yii\db\Query())
				->select(['id'])
				->from('forum_tag')
				->where('link=:link', ['link' => $linkTag])
				->one();
			$tagId = 0;
			if ($tag != null) {
				$tagId = $tag['id'];
				$linkRegion = $paths[0];
				$cityCheck = (new \yii\db\Query())
					->select(['id'])
					->from('city')
					->where(['link' => $linkRegion])
					->one();
				if (!empty($cityCheck)) return ['forum/city', ['link' => $linkRegion, 'cityId' => $cityCheck['id'], 'tagLink' => $linkTag, 'tagId' => $tag['id']]];
			}
		} else if (count($paths) == 1) {
			$linkRegion = $paths[0];
			$cityCheck = (new \yii\db\Query())
				->select(['id'])
				->from('city')
				->where(['link' => $linkRegion])
				->one();
			if (!empty($cityCheck)) return ['forum/city', ['link' => $linkRegion, 'cityId' => $cityCheck['id']]];
		}

		return false;
	}
}
