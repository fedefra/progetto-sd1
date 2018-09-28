<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest','foo');
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);

	include("db.php");
	$con=DB::getInstance()->getConn();

class RpcClient
{
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            'localhost',
            5672,
            'guest',
            'guest',
            'foo'
        );
        $this->channel = $this->connection->channel();
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "",
            false,
            false,
            true,
            false
        );
        $this->channel->basic_consume(
            $this->callback_queue,
            '',
            false,
            false,
            false,
            false,
            array(
                $this,
                'onResponse'
            )
        );
    }
    public function onResponse($rep)
    {
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }
    public function call($data)
    {
    
        $this->response = null;
        $this->corr_id = uniqid();
       $msg = new AMQPMessage(
             $data,
            array(
                'correlation_id' => $this->corr_id, //per legare la risposta alla richiesta
                'reply_to' => $this->callback_queue //callback coda
            )
        );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
        while (!$this->response) {
            $this->channel->wait();
        }
        return intval($this->response);
    }
}

if($_POST['id']==0){
	$row['riga']=$_POST['riga'];
	$data=json_encode($row);
}
else{
  $sql="SELECT * FROM prodotti WHERE id=".$_POST['id']."";
  		$result=$con->query($sql);
  		$messaggio='';
		if($result){
			while($row=$result->fetch_assoc()){
				$row['riga']=$_POST['riga'];
				$data=json_encode($row);

			}
			}
		}
$rpc = new RpcClient();
$response = $rpc->call($data);
echo  $response;