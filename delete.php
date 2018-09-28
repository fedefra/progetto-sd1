<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest','foo');
$channel = $connection->channel();

$channel->queue_delete('rpc_queue');

$channel->close();
$connection->close();

