<?php

require_once 'FacebookBot.php';

$bot = new FacebookBot();

//Il messaggio deve avere massimo 160 caratteri.
$welcomeMessage = "Benvenuto. Clicca su \"Inizia\" o invia START per ricevere aggiornamenti periodici sul terremoto del 24 agosto 2016. Invia STOP per annullare l'iscrizione.";  

$updated = $bot->setWelcomeMessage($welcomeMessage);
if($updated)
	echo "Messaggio di benvenuto aggiornato!\n";
else 
	echo "Errore nell'aggiornamento del messaggio di benvenuto\n";

?>