<?php

namespace PGS\RabbitMQBundle;

final class ExchangeType
{
    const TOPIC = 'topic';
    const DIRECT = 'direct';
    const FANOUT = 'fanout';
    const HEADERS = 'headers';
}
