<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest','foo');
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);

function estraiID($n)
{
       $n=json_decode($n,'true');
       $id=$n['riga'];
       $file = 'log.txt';
       $somecontent = "Letto messaggio ".$id."\n";
       if (!$handle = fopen($file, 'a')) {
             echo "Non si riesce ad aprire il file ($filename)";
             exit;
        }
        if (fwrite($handle, $somecontent) === FALSE) {
         echo "Non si riesce a scrivere nel file ($filename)";
         exit;
        }

       return $id;
   
}


echo " [x] Awaiting RPC requests\n";
$callback = function ($req) {
    $n = ($req->body);

    $msg = new AMQPMessage(
        (string) estraiID($n),
        array('correlation_id' => $req->get('correlation_id'))
    );
    $req->delivery_info['channel']->basic_publish(
        $msg,
        '',
        $req->get('reply_to')
    );
    $req->delivery_info['channel']->basic_ack(
        $req->delivery_info['delivery_tag']
    );
};
$channel->basic_qos(null, 1, null); //numero di messaggi consumati alla volta, in caso bisogna specificare più consumer
$channel->basic_consume('rpc_queue', '', false, false, false, false, $callback); //coda da cui consumare e funzione in callback da chiamare
while (count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();

