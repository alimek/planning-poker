<?php
/**
 * Created by PhpStorm.
 * User: grzegorz
 * Date: 23.11.16
 * Time: 10:57
 */

namespace PGS\RabbitMQBundle\Command;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use PGS\RabbitMQBundle\ExchangeType;
use PGS\RabbitMQBundle\Service\QueueConsumerInterface;
use PGS\RabbitMQBundle\Service\RabbitMQClient;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunQueueConsumerLoopCommand extends ContainerAwareCommand
{
    /**
     * @var RabbitMQClient
     */
    private $rabbitClient;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->rabbitClient = $this->getContainer()->get('pgs_rabbit_mq.service.rabbit_mqclient');
    }

    protected function configure()
    {
        $this->setName('app:consumer:run')
            ->addArgument('service', InputArgument::REQUIRED, 'Service?')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue?')
            ->addArgument('exchange', InputArgument::REQUIRED, 'Exchange?')
            ->setDescription('Starts the loop consuming RabbitMQ messages');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QueueConsumerInterface $service */
        $service = $this->getContainer()->get($input->getArgument('service'));
        if(!$service instanceof QueueConsumerInterface) {
            $output->writeln("Service should be implementing QueueConsumerInterface");
            return 1;
        }

        $exchange = $input->getArgument('exchange');
        $queue = $input->getArgument('queue');
        $this->timeStampedMessage('Processing '.$queue.' queue', $output);

        $channel = $this->rabbitClient->getClient()->channel();

        $channel->queueDeclare($queue, false, false, true, true);
        $channel->queueBind($queue, $exchange, $queue);

        $channel->run(
            function (Message $message, Channel $channel) use ($service, $output) {
                $this->timeStampedMessage(sprintf('Processing message: %s %s', $message->exchange, $message->routingKey), $output);
                $result = $service->consume($message);
                if ($result === true) {
                    $channel->ack($message);
                    $this->timeStampedMessage('Success', $output);
                    return;
                }
                $channel->nack($message);
                $this->timeStampedMessage($result, $output);
            },
            $queue
        );

        return 0;
    }

    /**
     * @param $message
     * @param OutputInterface $output
     */
    private function timeStampedMessage($message, OutputInterface $output) {
        $date = date('Y-m-d H:i:s');
        $output->writeln("[".$date."] ".$message);
    }

}