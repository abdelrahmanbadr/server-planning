<?php

namespace App\Entity;

use App\Exception\ValueNotValidException;
use Exception;

class Server
{
    /**
     * @var int
     */
    private $cpu;

    /**
     * @var int
     */
    private $ram;

    /**
     * @var int
     */
    private $hdd;

    public function __construct(int $cpu, int $ram, int $hdd)
    {
        if ($cpu < 0) {
            throw new ValueNotValidException("CPU value is not valid");
        }
        if ($ram < 0) {
            throw new ValueNotValidException("RAM value is not valid");
        }
        if ($hdd < 0) {
            throw new ValueNotValidException("HDD value is not valid");
        }
        $this->cpu = $cpu;
        $this->ram = $ram;
        $this->hdd = $hdd;
    }

    /**
     * @return int
     */
    public function getCPU()
    {
        return $this->cpu;
    }

    /**
     * @return int
     */
    public function getRAM()
    {
        return $this->ram;
    }

    /**
     * @return int
     */
    public function getHDD()
    {
        return $this->hdd;
    }

}