<?php

namespace App\Service;


use App\Constant\Constant;
use App\Contract\ServersPlanningServiceInterface;
use App\Entity\Server;
use App\Exception\VirtualMachinesCanNotBeEmptyException;

/**
 * This class should be responsible for calculating number of servers needed to host a specified
 * amount of virtual machines.
 * Class ServersPlanningService
 * @package App\Service
 */
class ServersPlanningService implements ServersPlanningServiceInterface
{
    /**
     * distribute implement a 'first fit' strategy
     *
     * @param Server $server
     * @param array $virtualMachines
     * @return int
     * @throws VirtualMachinesCanNotBeEmptyException
     * @throws \App\Exception\ValueNotValidException
     */
    public function distribute(Server $server, array $virtualMachines)
    {
        if (empty($virtualMachines)) {
            throw new VirtualMachinesCanNotBeEmptyException(Constant::EMPTY_VM_EXCEPTION_MESSAGE);
        }
        $originalServer = $server;

        $serversCount = 0;
        /** @var Server $virtualMachineItem */
        foreach ($virtualMachines as $virtualMachineItem) {

            if ($this->isVirtualMachineTooBig($originalServer, $virtualMachineItem)) {
                continue;
            }

            if ($this->isVirtualMachineTooBig($server, $virtualMachineItem)) {
                $server = $this->getServerWithRemainResources($originalServer, $virtualMachineItem);
                $serversCount++;
            } else {
                $server = $this->getServerWithRemainResources($server, $virtualMachineItem);
            }
            if ($serversCount == 0) {
                $serversCount++;
            }

        }
        return $serversCount;
    }

    /**
     * @param Server $server
     * @param Server $virtualMachineItem
     * @return Server
     * @throws \App\Exception\ValueNotValidException
     */
    private function getServerWithRemainResources(Server $server, Server $virtualMachineItem): Server
    {
        $remainCPU = $server->getCPU() - $virtualMachineItem->getCPU();
        $remainRAM = $server->getRAM() - $virtualMachineItem->getRAM();
        $remainHDD = $server->getHDD() - $virtualMachineItem->getHDD();

        return new Server($remainCPU, $remainRAM, $remainHDD);
    }

    /**
     * Check if virtual machine is too big for the server or not
     *
     * @param Server $server
     * @param Server $virtualMachineItem
     * @return bool
     */
    private function isVirtualMachineTooBig(Server $server, Server $virtualMachineItem): bool
    {
        if ($server->getCPU() - $virtualMachineItem->getCPU() < 0) {
            return true;
        }
        if ($server->getRAM() - $virtualMachineItem->getRAM() < 0) {
            return true;
        }
        if ($server->getHDD() - $virtualMachineItem->getHDD() < 0) {
            return true;
        }

        return false;
    }


}