<?php
require_once __DIR__.'/vendor/autoload.php';
use Herrera\Pdo\PdoServiceProvider;
use Silex\Application;


class DbManager
{
	private $app;

	/*Prende l'url del database memorizzato nella variabile d'ambiente 'DATABASE_URL'
	* e inizializza il pdo con i dati del db
 	*/
	function __construct()
	{
		$dbopts = parse_url(getenv('DATABASE_URL'));
		$this->app = new Application();
		$this->app->register(new Herrera\Pdo\PdoServiceProvider(),
			array(
        	'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
        	'pdo.username' => $dbopts["user"],
        	'pdo.password' => $dbopts["pass"]));	
	}

	function getAllUsers()
	{
		$query = 'SELECT id FROM USERS';
		$st = $this->app['pdo']->prepare($query);
	  	$st->execute();
	  	
	  	//var_dump($st->errorInfo());

	  	return $st;
	}

	function deleteUser($idToDelete)
	{
		$query = "DELETE FROM USERS WHERE id = '$idToDelete'";
		$st = $this->app['pdo']->prepare($query);
	  	$st->execute();

	  	//var_dump($st->errorInfo());
	}

	
	function addUser($idToAdd)
	{
		

		$query = "INSERT INTO USERS (id)
					SELECT '$idToAdd' WHERE
					NOT EXISTS (SELECT id FROM USERS WHERE id ='$idToAdd')";

		$st = $this->app['pdo']->prepare($query);
		$st->execute();
		
		//var_dump($st->errorInfo());
	}

}

?>