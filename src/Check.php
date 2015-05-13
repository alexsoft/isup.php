<?php
namespace Alexsoft\Isup;

class Check {

    const STATUS_WEBSITE_IS_UP   = 1;
    const STATUS_WEBSITE_IS_DOWN = 2;
    const STATUS_NOT_WEBSITE     = 3;
    const STATUS_API_ERROR       = 4;

    private $messages = [
        self::STATUS_WEBSITE_IS_UP   => 'It\'s just you. %s is up.',
        self::STATUS_WEBSITE_IS_DOWN => 'It\'s not just you! %s looks down from here.',
        self::STATUS_NOT_WEBSITE     => 'Huh? %s doesn\'t look like a site.',
        self::STATUS_API_ERROR       => 'Sorry! API is not available right now!'
    ];

    protected $url = 'http://isitup.org/%s.json';

    public function check($domain) {
        $status = $this->getStatus($domain);

        echo sprintf($this->messages[$status], $domain);
        echo "\n";
    }

    protected function getStatus($domain) {
        $opts = [
            'http' => array(
                'method' => "GET",
                'header' => "User-Agent: github.com/alexsoft/isup.php\r\n"
            )
        ];

        $context = stream_context_create($opts);

        $content = json_decode(file_get_contents(sprintf($this->url, $domain), false, $context), true);

        if (false === $content) {
            return static::STATUS_API_ERROR;
        }

        return $content['status_code'];
    }

}