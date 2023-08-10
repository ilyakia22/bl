<?

namespace app\lib;

class TextLib
{

    public static function ckeDecodeText($text, $forUpdate = false)
    {
        if ($forUpdate) $text = preg_replace_callback('/\[\[url2?=(.*?)##(.*?)##redirect\]\]/', 'app\lib\TextLib::ckeDecodeText_RedirectLinkUpdate', $text);
        else $text = preg_replace_callback('/\[\[url2?=(.*?)##(.*?)##redirect\]\]/', 'app\lib\TextLib::ckeDecodeText_RedirectLink', $text);
        return $text = preg_replace(
            array(
                '/href=/',
                '/\[\[url=(.*?)##(.*?)##blank\]\]/',
                '/\[\[url2=(.*?)##(.*?)##blank\]\]/',
                //'/\[\[url=(.*?)##(.*?)##redirect\]\]/',
                '/\[\[img=([0-9]*)\]\]/',
                '/\[\[youtube=([^\]]*)\]\]/',
                '/\[b\]/',
                '/\[\\/b\]/'
            ),
            array(
                'target="_blank" href=',
                '<a href="$1" title="$1" target="_blank">$2</a>',
                $forUpdate ? '$1' : '<a href="$1" title="$1" target="_blank">$2</a>',
                //'<a href="'.url('go/to').'?url=$1" title="$1" target="_blank">$2</a>',
                '<figure class="image"><img src="' . PHOTO_FORUM_MIDDLE_PATH_LOCAL . '$1.jpg" srcset="' . PHOTO_FORUM_SMALL_PATH_LOCAL . '$1.jpg 390w, ' . PHOTO_FORUM_MIDDLE_PATH_LOCAL . '$1.jpg 720w" sizes="100vw" width="720"></figure>',
                //$forUpdate?'<figure class="media"><oembed url="https://youtu.be/$1"></oembed></figure>':'<div class="video-wrap"><div class="video-container"><iframe src="//www.youtube.com/embed/$1" frameborder="0" width="560" height="315"></iframe></div></div>',
                $forUpdate ? '<figure class="media"><oembed url="https://youtu.be/$1"></oembed></figure>' : '<div class="youtube-wrapper"><div class="youtube" data-embed="$1"><div class="play-button"></div></div></div>',
                '<b>',
                '</b>'
            ),
            $text
        );
    }

    public static function ckeDecodeText_RedirectLinkUpdate($matches)
    {
        if (strpos($matches[0], '[url2') > 0) return $matches[1];
        else return '<a href="' . $matches[1] . '" target="_blank">' . $matches[2] . '</a>';
    }

    public static function ckeDecodeText_RedirectLink($matches)
    {
        return '<a href="/go/to?url=' . urlencode(urlencode($matches[1])) . '" title="' . urldecode($matches[1]) . '" target="_blank">' . $matches[2] . '</a>';
    }
}
