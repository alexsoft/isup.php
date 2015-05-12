<?php
namespace Alexsoft\Isup;

class Check {

    const STATUS_WEBSITE_IS_DOWN = 0;
    const STATUS_WEBSITE_IS_UP   = 1;
    const STATUS_SERVICE_ERROR   = 2;
    const STATUS_NOT_WEBSITE     = 3;

    protected $url = 'http://isup.me/%s';

    public function check($domain) {
        $this->echoResult(
            $this->getStatus($domain)
        );
    }

    protected function getStatus($domain) {
        $content = file_get_contents(sprintf($this->url, $domain));

        if (strpos($content, 'doesn\'t look like a site')) {
            return static::STATUS_NOT_WEBSITE;
        }

        if (strpos($content, 'looks down')) {
            $this->echoResult(static::STATUS_WEBSITE_IS_DOWN);
        }

        return static::STATUS_WEBSITE_IS_UP;
    }

    protected function echoResult($status) {
        echo $status;
    }

}