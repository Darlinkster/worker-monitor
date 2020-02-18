## Worker monitor

Package for sending rabbit messages to worker monitor api.

#### Usage
```
AMQPMessage $rabbitMessage


$config = new \WorkerMonitor\Model\Config();
$config->setApiUrl('api_url');
$config->setApiKey('api_key');

$monitor = new \WorkerMonitor\Monitor($config);

$message = $monitor->convertMessage($rabbitMessage);
$monitor->sendMessageToApi($message);
```
