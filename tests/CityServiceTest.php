<?php

namespace Weather\Test;

use Weather\Application\CityClientInterface;
use Weather\Application\CityService;
use Weather\Application\WeatherClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Weather\Domain\City;
use Weather\Domain\Weather;

class CityServiceTest extends TestCase
{
    /**
     * @var MockObject|WeatherClientInterface
     */
    private $weatherClient;
    /**
     * @var MockObject|CityClientInterface
     */
    private $musementClient;

    protected function setUp(): void
    {
        $this->weatherClient = $this->createMock(WeatherClientInterface::class);
        $this->musementClient = $this->createMock(CityClientInterface::class);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testRun()
    {
        $this->musementClient->expects($this->once())->method('getCities')->willReturn(
            [
                new City('First City', 1.20, 2.30),
                new City('Second City', 3.20, 4.30),
                new City('Third City', 5.20, 6.30),
            ]
        );

        $this->weatherClient->expects($this->exactly(3))->method('getWeatherForCity')->willReturn(
            new Weather('location name', ...['condition name'])
        );

        (new CityService($this->weatherClient, $this->musementClient))->getWeatherConditionsForCities();
    }
}
