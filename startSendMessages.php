<?php
/*
 *Invia i nuovi feed a tutti gli utenti.
 */

require_once 'FacebookBot.php';
require_once 'DbManager.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (!$update)
	exit;

$feedTitle = isset($update['title']) ? $update['title'] : null;
$feedLink = isset($update['link']) ? $update['link'] : null;

if(isset($feedTitle) && isset($feedLink))
{
	/*PER DEBUG
	 *$bot = new FacebookBot();
	 *$bot -> sendGenericMessage('1109567802412082', $feedTitle, $feedLink);
	 */
	$bot = new FacebookBot();
	$userManager = new DbManager();
	$st = $userManager->getAllUsers();
	while ($row = $st->fetch(PDO::FETCH_ASSOC))
	{
		$bot->sendGenericMessage($row['id'], $feedTitle, $feedLink);
	}
}

return;

?>
