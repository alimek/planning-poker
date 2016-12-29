# PGS RabbitMQ Bundle

###configuration

Put rabbitMQ host configuration and credentials into config.yml

```yaml
pgs_rabbit_mq:
    host: '%rabbitmq.host%:%rabbitmq.port%'
    vhost: '%rabbitmq.vhost%'
    user: '%rabbitmq.user%'
    password: '%rabbitmq.password%'
```

Add line to AppKernel.php
```php
    new PGS\RabbitMQBundle\PGSRabbitMQBundle(),
```

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
//...
            new PGS\RabbitMQBundle\PGSRabbitMQBundle(),
//...  
        ];
        
//...  
```

###usage

#####Publishing messages to queue
Create $message with config info using factory function
 
1. using topic message routing
```php
$message = PGSMessage::createTopicMessage(string $message, string $exchange, string $topic);
```

2. using direct message routing
```php
$message = PGSMessage::createDirectMessage(string $body, string $exchange, string $routingKey);
```

3. using fanout message routing
```php
$message = PGSMessage::createFanoutMessage(string $body, string $exchange);
```
4. using headers message routing
```php
$message = PGSMessage::createHeadersMessage(string $body, string $exchange, $headers);
```

And then publish created message using 'pgs_rabbit_mq.service.rabbit_mqpublisher' service
```php
$this->get('pgs_rabbit_mq.service.rabbit_mqpublisher')->publish($message);
```

#####Consuming messages
There are two ways to consume messages

1. using one time consumer
 use method 'consume' from 'pgs_rabbit_mq.service.rabbit_mqconsumer' service
 ```php
 $this->get('pgs_rabbit_mq.service.rabbit_mqconsumer')->consume('queue.name');
 ```
2. by starting command with loop running service method when message for given queue appear
```
php bin/console app:consumer:run <service name> <queue name> <exchange name>
```
used service must implement `QueueConsumerInterface`
