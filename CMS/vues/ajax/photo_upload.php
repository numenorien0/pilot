<?php
$medias = new Medias();

//$connexion = new Connexion();

if(1)
{
	if(isset($_FILES['file']['name']))
	{
		$name = $_FILES['file']['name'];
		$positionExtension = strrpos($name, ".");
		$extension = substr($name, $positionExtension);
		$name = time().$extension;
		
		
		$medias->upload($name, $_FILES['file']['tmp_name']);
		
	}	
	
	if(isset($_GET['action']) AND $_GET['action'] == "list")
	{
		$liste = $medias->get_medias("intermediate");
		
		if($liste != "none")
		{
			$liste = json_encode($liste);
			echo $liste;
		}
		
	}
	
	
	if(isset($_GET['action']) AND $_GET['action'] == "file_details")
	{
		$file = $medias->get_file_details($_GET['ID']);
		
		echo json_encode($file);
		
	}
	
	if(isset($_POST['action']) AND $_POST['action'] == "editMeta")
	{
		$medias->changeMeta($_POST['data'], $_POST['ID']);
	}
	
	if(isset($_POST['action']) AND $_POST['action'] == "delete")
	{
		$medias->delete($_POST['ID']);
	}
}
?>