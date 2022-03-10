<?php

namespace noahjahn\phpfpmstatusmonitor\services;

use Craft;
use craft\helpers\UrlHelper;
use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use yii\base\Component;
use noahjahn\phpfpmstatusmonitor\PhpFpmStatusMonitor;

class PhpFpm extends Component
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->client === null) {
            $this->client = Craft::createGuzzleClient([
                'base_uri' => UrlHelper::baseSiteUrl(),
            ]);
        }
    }

    /**
     * Returns PHP FPM status information
     *
     * @return array
     * @throws RequestException if the request gave a non-2xx response
     */
    public function getStatus(): array
    {
        return Json::decode((string)$this->request('GET', PhpFpmStatusMonitor::getInstance()->getSettings()->path . '?json')->getBody());
    }

    /**
     * @param string $method
     * @param string $uri
     * @return ResponseInterface
     * @throws RequestException
     */
    public function request(string $method, string $uri): ResponseInterface
    {
        return $this->client->request($method, $uri);
    }
}