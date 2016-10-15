<?php
/*Gestisce l'interazione con gli utenti:
 * - Nuova iscrizione
 * - Eliminazione iscrizione
 */

require_once 'FacebookBot.php';
require_once 'DbManager.php';
require_once 'config.php';

$bot = new FacebookBot();
$bot->run();
$messages = $bot->getReceivedMessages();

$userManager = new DbManager();

try
{
  foreach ($messages as $message)
  {
    if(isset($message->senderId))
    {
      $respMessage = 'Messaggio non valido. Invia STOP se non vuoi più ricevere aggiornamenti.';
      $recipientId = $message->senderId;
      if(isset($message->text) && ($message->text==='STOP'))
      {
        $userManager->deleteUser($message->senderId);
        $respMessage = "La tua iscrizione è stata annullata.";
      }
      elseif ((isset($message->text) && ($message->text==='START')) ||
              isset($message->postback) && ($message->postback === NUOVA_ISCRIZIONE))
      {
        $userManager->addUser($message->senderId);
        $respMessage = "Iscrizione effettuata. Inizierai a ricevere aggiornamenti appena saranno disponibili.";
      }
      $bot->sendTextMessage($recipientId, $respMessage);
    }
  }
}
catch(Exception $exc)
{
  error_log($exc->getMessage()."\n");
  return false;
}

return true;

?>