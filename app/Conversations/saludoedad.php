<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class saludoedad extends Conversation
{

    protected $nombre;
    protected $edad;

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    
    public function run()
    {
      $this -> preguntarNombre();
      
        //
    }

    public function preguntarNombre()
    {
       
        $this->ask('¿Cómo te llamas?', function (Answer $response) 
	{
        $this -> nombre = $response ->getText();

        $this -> preguntarEdad();

	});
        
    }

    public function preguntarEdad ()
    {
        $this->ask('Cual es tu edad?', function (Answer $response) 
        {
            $this -> edad = $response ->getText();
    
            $this -> mostrarResultados();
        });

    }

    public function mostrarResultados ()
    {
        $this->say('hola  ' . $this->nombre); 
        
        if($this-> edad >= 18)
        {
            $this ->say("Veo que eres mayor de edad");

        }

        else
        {

            $this ->say("Veo que eres menos de edad");
        }

    }
}
