<?php

namespace API\YaMetrika\Service\V1;

use API\YaMetrika\Service\AbstractService;
use Carbon\Carbon;
use DateTime;

/**
 * Class YaMetrika
 *
 * @author  Alexey Marchenko <mavrin_88@mail.ru>
 * @link    https://github.com/mavrin88/YandexMetrika
 * @package API\YaMetrika
 */
class YaMetrika extends AbstractService
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
    private $token;

    /**
     * Id counter
     *
     * @var int
     */
    private $counterId;

    /**
     * Data from Yandex Metrica
     *
     * @var array
     */
    public $data;


    public function __construct($token, $counterId)
    {
        $this->token = $token;
        $this->counterId = $counterId;
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





    /**
     * Получаем возраст и пол посетителей за N дней
     *
     * @param int $days
     * @param int $limit
     *
     * @return $this
     */
    public function getConversions($days = 7, $limit = 20)
    {
        list($startDate, $endDate) = $this->differenceDate($days);

        $this->getConversionsForPeriod($startDate, $endDate, $limit);

        return $this;
    }

    /**
     * Получаем возраст и пол посетителей за выбранный период
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param int      $limit
     *
     * @return $this
     */
    public function getConversionsForPeriod(DateTime $startDate, DateTime $endDate, $limit = 20)
    {
        $params = [
            'date1'      => $startDate->format('Y-m-d'),
            'date2'      => $endDate->format('Y-m-d'),
            'filters'    => "ym:s:AdvEngine=='price_ru'",
            'preset'     => 'conversion',
            'limit'      => $limit,
        ];

        $url = $this->creataLink($params);

        $this->data = $this->query($url);

        return $this;
    }
}
