<?php

namespace App\Contract;

use App\Entity\Server;

interface ServersPlanningServiceInterface
{
    /**
     * @param Server $server
     * @param array $virtualMachines
     * @return mixed
     */
    public function distribute(Server $server, array $virtualMachines);

}