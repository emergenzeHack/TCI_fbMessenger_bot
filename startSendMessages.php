<?php
/*
 *Invia i nuovi feed a tutti gli utenti.
 */

require_once 'FacebookBot.php';
require_once 'DbManager.php';

$feedTitle = isset($_POST['title']) ? $_POST['title'] : null;
$feedLink = isset($_POST['url']) ? $_POST['url'] : null;

if(isset($feedTitle) && isset($feedLink))
{
	/*PER DEBUG
	 *$bot = new FacebookBot();
	 *$bot -> sendGenericMessage('1109567802412082', $feedTitle, $feedLink);
	 */
	$bot = new FacebookBot();
	$userManager = new DbManager();
	$st = $userManager->getAllUsers();
	$idTodel = array();
	while ($row = $st->fetch(PDO::FETCH_ASSOC))
	{
		$respObject = $bot->sendGenericMessage($row['id'], $feedTitle, $feedLink);
		if(is_object($respObject) && isset($respObject->error) && $respObject->error->code == 200)
			$idTodel[] = $row['id'];
	}

	if(count($idTodel)>0)
	{
		foreach ($idTodel as $id)
		{
			$userManager->deleteUser($id);	
		}
	}
}

return;

?>
