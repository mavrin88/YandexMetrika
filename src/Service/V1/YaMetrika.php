<?php

namespace API\YaMetrika;

use API\YaMetrika\Exceptions\YaMetrikaException;
use Carbon\Carbon;

/**
 * Class YaMetrika
 *
 * @author  Alexey Marchenko <mavrin_88@mail.ru>
 * @link    https://github.com/mavrin88/YandexMetrika
 * @package API\YaMetrika
 */
class YaMetrika extends \AbstractService
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
}
