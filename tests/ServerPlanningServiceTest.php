<?php

use PHPUnit\Framework\TestCase;
use App\Exception\{ValueNotValidException, VirtualMachinesCanNotBeEmptyException};
use App\Service\ServersPlanningService;
use App\Entity\Server;

class ServerPlanningServiceTest extends TestCase
{
    /**
     * @return array
     * @throws ValueNotValidException
     */
    public function dataProvider()
    {
        return [
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(3, 32, 100),
                    new Server(3, 32, 100),
                    new Server(5, 32, 100),
                ],
                "result" => 2
            ],
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(3, 32, 100),
                    new Server(3, 32, 100),
                    new Server(3, 32, 100),
                ],
                "result" => 3
            ],
            [
                "server" => new Server(2, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(1, 16, 10),
                    new Server(2, 32, 100),
                ],
                "result" => 2
            ],
            [
                "server" => new Server(2, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(2, 32, 100),
                    new Server(1, 16, 10),
                ],
                "result" => 3
            ],
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(2, 32, 100),
                    new Server(1, 16, 10),
                ],
                "result" => 3
            ],
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(2, 16, 10),
                    new Server(1, 16, 10),
                ],
                "result" => 2
            ],
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(1, 2, 10),
                    new Server(1, 14, 10),
                ],
                "result" => 1
            ],
            [
                "server" => new Server(3, 32, 100),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(1, 2, 10),
                    new Server(10, 2, 10),
                    new Server(4, 1, 1),
                    new Server(1, 14, 10),
                ],
                "result" => 1
            ],
            [
                "server" => new Server(1, 1, 1),
                "virtualMachines" => [
                    new Server(1, 16, 10),
                    new Server(1, 2, 10),
                    new Server(10, 2, 10),
                    new Server(4, 1, 1),
                    new Server(1, 14, 10),
                ],
                "result" => 0
            ],
            [
                "server" => new Server(0, 0, 0),
                "virtualMachines" => [
                    new Server(10, 2, 10),
                    new Server(0, 0, 0),
                    new Server(0, 0, 0),
                    new Server(0, 0, 0),
                ],
                "result" => 1
            ]
        ];
    }

    /**
     * @throws ValueNotValidException
     * @throws VirtualMachinesCanNotBeEmptyException
     */
    public function testThrowExceptionIfVirtualMachinesEmpty(): void
    {
        $this->expectException(VirtualMachinesCanNotBeEmptyException::class);

        $service = new ServersPlanningService();
        $service->distribute((new Server(1, 1, 1)), []);
    }

    /**
     * @throws ValueNotValidException
     */
    public function testThrowExceptionIfValueNotValid(): void
    {
        $this->expectException(ValueNotValidException::class);

        new Server(-1, -1, -1);
    }


    /**
     * @param Server $server
     * @param array $virtualMachines
     * @param int $result
     * @throws ValueNotValidException
     * @throws VirtualMachinesCanNotBeEmptyException
     * @dataProvider dataProvider
     */
    public function testServerPlanningDistribution(Server $server, array $virtualMachines, int $result): void
    {
        $service = new ServersPlanningService();
        $this->assertEquals($service->distribute($server, $virtualMachines), $result);
    }

}