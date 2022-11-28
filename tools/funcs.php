<?
class myCURL
{
    var $headers;
    var $user_agent;
    var $compression;
    var $cookie;
    var $proxy;
    var $showHeader = false;

    function __construct($host)
    {
        $this->headers[] = 'Host: ' . $host;
        $this->headers[] = 'User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
        $this->headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $this->headers[] = 'Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3';
        //$this->headers[] = 'Accept-Encoding: gzip, deflate';
        $this->headers[] = 'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7';
        $this->headers[] = 'Keep-Alive: 115';
        $this->headers[] = 'Connection: keep-alive';
        $this->headers[] = 'Expect:';
        $this->user_agent = '';
    }

    function get($url, $headers_output = true)
    {
        $process = curl_init($url);
        $headers = $this->headers;
        if ($this->cookie != '') $headers[] = 'Cookie: ' . $this->cookie;
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        if ($this->showHeader) {
            curl_setopt($process, CURLOPT_HEADER, 1);
        } else {
            curl_setopt($process, CURLOPT_HEADER, 0);
        }
        curl_setopt($process, CURLOPT_TIMEOUT, 30);

        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 0);
        if (strpos($url, 'ttps') == 1) {
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
        }
        $return = curl_exec($process);
        //echo curl_errno($process);
        //echo curl_error($process);
        $info = curl_getinfo($process, CURLINFO_HTTP_CODE);

        curl_close($process);

        return array('content' => $return, 'info' => $info);
    }

    function post($url, $data, $isJSON = false, $isAjax = false, $addHeaders = array())
    {
        $process = curl_init($url);

        if ($isAjax) $this->headers[] = 'X-Requested-With: XMLHttpRequest';
        if ($isJSON) {
            $jsonData = json_encode($data);
            $this->headers[] = 'Content-Type: application/json; charset=UTF-8';
            $this->headers[] = 'Content-Length: ' . strlen($jsonData);
        }
        foreach ($addHeaders as $row) {
            $this->headers[] = $row;
        }
        $headers = $this->headers;

        if ($this->cookie != '') $headers[] = 'Cookie: ' . $this->cookie;

        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        if (strpos($url, 'vk.com') !== false || strpos($url, 'ok.ru') !== false || !$this->showHeader) {
            curl_setopt($process, CURLOPT_HEADER, 0);
        } else {
            curl_setopt($process, CURLOPT_HEADER, 1);
        }
        curl_setopt($process, CURLOPT_TIMEOUT, 30);

        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_POST, 1);

        if ($isJSON) {
            curl_setopt($process, CURLOPT_POSTFIELDS, $jsonData);
        } else {
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        if (strpos($url, 'ttps') == 1) {
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($process, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        }
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 0);

        $return = curl_exec($process);
        $info = curl_getinfo($process, CURLINFO_HTTP_CODE);
        print_r(curl_error($process));
        curl_close($process);

        return array('content' => $return, 'info' => $info);
    }

    function error($error)
    {
        echo $error;
    }
}
