
#### Installation 
 1- clone the project
 
    $ git clone https://github.com/abdelrahmanbadr/server-planning
    
2- Run `composer install`
     
#### Library Usage:

`ServersPlanningService` implement `ServersPlanningServiceInterface`

```
use App\Service\ServersPlanningService;

$virtualMachines = [new Server(1, 16, 10),new Server(1, 16, 10),new Server(2, 32, 100)];
$server = new Server(2, 32, 100);
$serverPlanningService = new ServersPlanningService();
$result = $serverPlanningService->distribute();
echo $result;
```
Note: Server and virtual machine properties are CPU, RAM and HDD, these properties values should not be less than zero. 
#### Project structure
- Contract : Has interface that server planning server extends.
- Constant : Has all constant related with server planning business logic.
- Entity : Has server enitity.
- Services : Services  used to hide and encapsulate library business Logic.

#### Running Unit tests:
    $ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests
 
#### Improvments(@todo):
    1- Add Cli command to calculate server-plainng result
    2- Write more test cases to increase code coverage
    3- Make it as composer package that can be used via composer require