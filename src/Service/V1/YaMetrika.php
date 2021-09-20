<?php

namespace API\YaMetrika\Service\V1;

use API\YaMetrika\Service\HttpClient;
use Carbon\Carbon;
use DateTime;

/**
 * Class YaMetrika
 *
 * @author  Alexey Marchenko <mavrin_88@mail.ru>
 * @link    https://github.com/mavrin88/YandexMetrika
 * @package API\YaMetrika
 */
class YaMetrika
{
    /**
     * URL API Yandex Metrika
     *
     * @var string
     */
    private $endPoint = 'https://api-metrika.yandex.ru/stat/v1/data';

    /**
     * Token API
     *
     * @var string
     */
    private $client;

    /**
     * Id counter
     *
     * @var int
     */
    private $counterId;


    public function __construct($token, $counterId)
    {
        $this->client = new HttpClient($token);
        $this->counterId = $counterId;

    }

    /**
     * We get visitors from search engines in N days.
     *
     * @param int $days
     * @param int $limit
     *
     * @return $this
     */
    public function getUsersSearchEngine($days = 30, $limit = 10)
    {
        list($startDate, $endDate) = $this->differenceDate($days);

        return $this->getUsersSearchEngineForPeriod($startDate, $endDate, $limit);
    }

    /**
     * We get users from search engines for the selected period.
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param int      $limit
     *
     * @return $this
     */
    public function getUsersSearchEngineForPeriod(DateTime $startDate, DateTime $endDate, $limit = 10)
    {
        $params = [
            'date1'      => $startDate->format('Y-m-d'),
            'date2'      => $endDate->format('Y-m-d'),
            'metrics'    => 'ym:s:users',
            'dimensions' => 'ym:s:searchEngine',
            'filters'    => "ym:s:trafficSource=='organic'",
            'limit'      => $limit,
        ];

        $url = $this->creataLink($params);

        return $this->client->query($url);
    }

    /**
     * Calculate the end and start date.
     *
     * @param $amountOfDays
     *
     * @return array
     */
    private function differenceDate($amountOfDays)
    {
        $startDate = Carbon::today()->subDays($amountOfDays);
        $endDate = Carbon::today();

        return [$startDate, $endDate];
    }

    public function creataLink($params)
    {
        return $this->endPoint . '?' . http_build_query(array_merge($params, ['ids' => $this->counterId]), null, '&');
    }

}
