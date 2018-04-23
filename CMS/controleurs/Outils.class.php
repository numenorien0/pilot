<?php
class Outils extends DB
{
	private $_db;
	private $_count = 0;
	private $_advanced;

	public function __construct()
	{
		$this->_db = parent::__construct();
	}

	public function listAllPlugins()
	{
		$liste = scandir("plugins");
		foreach($liste as $vue)
		{
			if($vue != "." AND $vue != ".." AND $vue != "get_started")
			{
				$this->_count++;
				$fichier = str_replace(".php", "", $vue);
				$fichierXML = str_replace(".php", "", $vue).".xml";
				if(file_exists("plugins/".$vue."/infos/".$fichierXML))
				{
					$fichierXML = file_get_contents("plugins/".$vue."/infos/".$fichierXML);
					$elementAAfficher = new SimpleXMLElement($fichierXML);
					$nom = $elementAAfficher->name;
					#print_r($elementAAfficher);
					#echo "<br/><br/><br/>";
					$page = $elementAAfficher->pages->page;
					
					$icone = "plugins/".$vue."/images/".$elementAAfficher->icone;
					$description = $elementAAfficher->description;

					
					if($elementAAfficher->state != "disabled")
					{
						echo "<div class='col-sm-3 toolsPadding'><a class='tools' href='?tools=".$vue."&page=".$page."'><div style='padding: 0px' class='cadre col-sm-12'>";
						echo "<div class='iconeAppContainer' style='background-image: url($icone)'></div>";
						echo "<h3 class='appName'>".$nom."</h3>";
						echo "<p class='notYet'>".$description."</p>";
						echo "</div></a></div>";
					}
					else
					{
						$this->_count--;
					}
				}
			}
		}

		if($this->_count == 0)
		{
			echo "<div class='col-sm-12 oops'>Oops!</div><div class='col-sm-12 explicationsOops'>Pas encore de plugin</div>";				
		}

		$vue = "get_started";
		//$fichier = str_replace(".php", "", $vue);
		$fichierXML = $vue.".xml";
		if(file_exists("plugins/".$vue."/infos/".$fichierXML))
		{
			$fichierXML = file_get_contents("plugins/".$vue."/infos/".$fichierXML);
			$elementAAfficher = new SimpleXMLElement($fichierXML);
			$nom = $elementAAfficher->name;
			$description = $elementAAfficher->description;
			
			#echo "<a class='toolsTuto' href='?tools=".$vue."'><div class='cadre col-sm-12'>";
			#echo "<h3>".$nom."</h3>";
			#echo "<p class='notYet2'>".$description."</p>";
			#echo "</div></a>";
		}
		$this->advancedMod();
		
		if($this->_advanced == "true")
		{
			echo "
			<div class='col-sm-12' id='dropfile'>
				<div class='col-sm-12 explicationUpload'>Glissez pour installer un module</div>
			</div>";
		}
	}
	
	public function advancedMod()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'advanced_mod'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_advanced = $donnees['valeur'];
		}
	}
}
?>

