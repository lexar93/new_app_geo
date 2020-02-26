<?php 
require './vendor/autoload.php';
 
use Workerman\Worker;
use PHPSocketIO\SocketIO;
 
 
// escuchamos en el puerto 2020
$io = new SocketIO(2020);
 
//evento de socketio cada vez que un nuevo socket se conecta (abre la web)
$io->on('connection', function($socket)
{
   
 
    // cuando se ejecute en el cliente el evento add user
    $socket->on('add comment', function ($comment) use($socket)
    {
        
        
        // guardamos al usuario en sesión
        $socket->username = $username;
        
        //añadimos al cliente a la lista global
        $usernames[$username] = $username;
        ++$numUsers;
        $socket->loggedUser = true;
        $socket->emit('login', array( 
            'numUsers' => $numUsers,
            'usernames' => $usernames,
        ));
 
        // notificamos a todos que un usuario ha entrado
        $socket->broadcast->emit('user joined', array(
            'username' => $socket->username,
            'numUsers' => $numUsers,
            "usernames"=> $usernames
        ));
    });

    // cuando se ejecute en el cliente el evento new message
    $socket->on('ranking', function($ranking) use($socket)
    {
        //me notifico del ranking que he publicado
        $socket->emit("ranking", array(
                "action" => "yo",
                "message" => "Yo: " . $ranking
            )
        );
 
        //notificamos al resto del ranking que he actualizado
        $socket->broadcast->emit("ranking", array(
            "action" => "ranking",
            "ranking" => $socket->username . " dice: " . $ranking
        ));
    });
 
   
});
 
Worker::runAll();