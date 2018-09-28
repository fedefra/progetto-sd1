var url='http://localhost/rabbitmq';
var url_rabbit='http://localhost:15672/api/';
var counter=1;

function invia(){
	var numero = $('#numero').val();
	for(i=1;i<=numero;i++){
		riga=$('tr#'+i);
		messaggio='{"titolo":"'+$(riga).find('.titolo').html()+'","descrizione:"'+$(riga).find('.descrizione').html()+'"}';

		$('#coda tr:last').after('<tr id=send_'+counter+'><td>'+counter+'</td><td>'+messaggio+'</td></tr>');
		

		$.ajax({
			        url: url+'/send.php',
			        type:'POST',   
			        //async:false,
			        dataType: 'json', 	
			        data : { id:i,
			        		 riga:counter
			         },       
			        success: function(string){
			        	console.log(string);
						alert='<div class="alert alert-success" role="alert">Il messaggio <b>'+string+'</b> è stato ricevuto</div>';
		                $('.receiver-box').append(alert); 

		                $('#send_'+string).fadeOut(2000);   
			        },
			         error: function(data) {
			        	  alert("errore"+data);
		   	},
		});
		counter++;
	}
}

function pulisci(){
	$('.receiver-box').html(''); 
}

function receiver(){

alert='<div class="alert alert-success" role="alert">Receiver attivo</div>';
$('.receiver-box').append(alert); 

		$.ajax({
			url: url+'/receiver.php',
			type:'GET',   
			success: function(string){
				console.log(string);
			}

	});
}

function cancella(){
		$.ajax({
			url: url+'/delete.php',
			type:'GET',   
			success: function(string){
				if(string==0){
					
				}
			}

	});
	}