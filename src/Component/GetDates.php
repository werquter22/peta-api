<?php

declare(strict_types=1);

namespace App\Component;

use DateInterval;
use DateTime;

class GetDates
{
    public function getTodayDate(): DateTime
    {
        return $date = new DateTime();
    }

    public function getCurrentTime(): int
    {
        return (int)$date = new DateTime('H:i:s');
    }

    public function getYesterdayDate(): DateTime
    {
        $date = new DateTime();
        $interval = new DateInterval('P1D');

        return $date->sub($interval);
    }

    public function getLastWeekDate(): DateTime
    {
        $date = new DateTime();
        $interval = new DateInterval('P7D');

        return $date->sub($interval);
    }

    public function getLastMonthDate(): DateTime
    {
        $date = new DateTime();
        $interval = new DateInterval('P30D');

        return $date->sub($interval);
    }
}
