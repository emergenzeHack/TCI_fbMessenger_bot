<?php

/*Abilita il bottone start che viene visualizzato quando un utente
 * ha la prima interazione con la pagina, e imposta una callback
 */
require_once 'FacebookBot.php';
require_once 'config.php';

$bot = new FacebookBot();
$updated = $bot->setStartButton(NUOVA_ISCRIZIONE);
if($updated)
{
	echo "Callback per pulsante start attivato\n";
}
else 
{
	echo "Si è verificato un errore nell'impostare la callback\n";
}