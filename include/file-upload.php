<?php

function chargeFile($file)
{
	if (isset($_FILES[$file]['name']) && !empty($_FILES[$file]['name'])) {
		$temp = $_FILES[$file]['tmp_name'];
		$name = $_FILES[$file]['name'];
		$size = $_FILES[$file]['size'];
		$type = $_FILES[$file]['type'];
		$ext = $_FILES[$file]['extension'];

		// Crée un nom de fichier unique commençant par $file (image ou vidéo)
		$file = uniqid($file);
		var_dump($type);

		// Défini une extension en fonction du type de fichier
		switch ($type) {
			case 'video/mp4':
				$extension = '.mp4';
				break;
			case 'image/jpeg':
				$extension = '.jpg';
				break;
			case 'image/png':
				$extension = '.png';
				break;
			case 'audio/mpeg':
				$extension = '.mp3';
				break;
			default:
				$extension = '';
		}

		// Ajoute l'extension au nom de fichier
		$file = $file . $extension;
		var_dump($file);

		// déplacement du fichier reçu
		move_uploaded_file($temp, '../images/uploads/' . $file);
		return $file;
	}
	return null;
}
