<?php
use App\Http\Controllers\BotManController;

use App\Conversations\saludoedad;
use App\Conversations\RealizarQuizConversacion;

$botman = resolve('botman');

/////////////////// MODIFICACIONES DE ACA PARA ABAJO

/*

$botman->hears('hola', function ($bot) {
    $bot->reply('Como estas! todo bien?');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('buen dia', function ($bot) {
    $bot->reply('es un gusto saludarte');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('Yo soy {nombre}', function ($bot, $nombre) {
	$bot->reply('Hola ' . $nombre);
});

$botman->hears('Soy {nombre} el {apodo}', 
               function ($bot, $nombre, $apodo) {
	$bot->reply('Hola ' . $nombre . 
                ' también conocido como ' . $apodo);
});

$botman->hears('cuanto es {primero} mas {segundo}', 
               function ($bot, $primero, $segundo) {
                   $suma = $primero + $segundo;
	$bot->reply('La suma da como resultado ' .  $suma );
});

$botman->hears ('saludame', function($bot){
    $bot->startConversation(new saludoedad());

}

)->stopsconversation();


$botman->fallback(function ($bot) {
	$bot->reply("No te entendí, ¿podrías ser mas específico?");
});
*/

///inicio

$botman->hears('/start', function ($bot) {
	$nombres = $bot->getUser()->getFirstName() ?: "desconocido";
	$bot->reply('Hola ' . $nombres . ', bienvenido al bot SimpleQuizzes!');
});

/// ayuda

$botman->hears('/ayuda', function ($bot) {
	$ayuda = ['/ayuda' => 'Mostrar este mensaje de ayuda',
          	'acerca de|acerca' => 'Ver la información quien desarrollo este lindo bot',
          	'listar quizzes|listar' => 'Listar los cuestionarios disponibles',
          	'iniciar quiz <id>' => 'Iniciar la solución de un cuestionario',
          	'ver puntajes|puntajes' => 'Ver los últimos puntajes',
          	'borrar mis datos|borrar' => 'Borrar mis datos del sistema'];
    
	$bot->reply("Los comandos disponibles son:");

	foreach($ayuda as $key=>$value)
	{
    		$bot->reply($key . ": " . $value);
	}
});

/// acerca de

$botman->hears('acerca de|acerca', function ($bot) {
	$msj = "Desarrollado por Carlos Andres Marquez Mejia";

	$bot->reply($msj);
});

$botman->hears('listar quizzes|listar', function ($bot) {
	$quizzes = \App\Quiz::orderby('titulo', 'asc')->get();

	foreach($quizzes as $quiz)
	{
    		$bot->reply($quiz->id."- ".$quiz->titulo);
	}

	if(count($quizzes) == 0)
    		$bot->reply("Ups, no hay cuestionarios para mostrar.");
});


$botman->hears('iniciar quiz {id}', function ($bot, $id) {
	$bot->startConversation(
new \App\Conversations\RealizarQuizConversacion($id));
})->stopsConversation();






$botman->fallback(function ($bot) {
	$bot->reply("No entiendo que quieres decir, vuelve a intentarlo.");
});
