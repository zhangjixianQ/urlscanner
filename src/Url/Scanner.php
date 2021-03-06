<?php
namespace Zhangjixian\UrlScanner\Url;
// 在composer.json里面指定了，Zhangjixian\UrlScanner => src

use GuzzleHttp\Client;

/**
 * summary
 */
class Scanner
{

    protected $urls;

    protected $httpClient;
    /**
     * summary
     */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    /**
     * 获取访问指定URL的HTTP状态吗
     * @param  $url
     * @return int
     */
    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }


    /**
     * 获取死链
     * @return array
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invalidUrls, ['url' => $url, 'status' => $statusCode]);
            }
        }
        return $invalidUrls;
    }
}

