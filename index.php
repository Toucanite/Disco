<?php
	// Cr�er une constantes pour le nombre de DIV
	header("refresh: 1;");
	$nbrDivLargeur = 7;
	$nbrDivHauteur = 4;
	define('nbrDIV', $nbrDivLargeur*$nbrDivHauteur);

	// Cr�er une fonction qui retourne une couleur al�atoire au format string de 6
	// chiffres hexadecimal, par exemple '0B34A9', chaque couleur est au format RVB
	// (rouge, vert bleu) dont 2 caract�res hexad�cimal correspondent � chacune de ces couleurs
	function couleuraleatoire() {
			// On tir un chiffre al�atoirement entre 0 et 255
			// On transforme notre chiffre tir� en hexad�cimal
			// Si le chiffre hexad�cimal ne prend qu'un seul caract�re (par exemple 'A') on le
			// transforme en '0A' car une couleur en CSS est toujours faite de 6 caract�res
			$chiffres = array();
			for ($i=0; $i < 3; $i++) {
				$aleatoire = dechex(rand(0,255));
				$chiffres[$i] = (strlen($aleatoire) == 2) ? $aleatoire : "0".$aleatoire;
			}
		// On renvoi la couleur al�atoire cr��e, par exemple '0AFF00'
		return ($chiffres[0].$chiffres[1].$chiffres[2]);
	}

	// Une fonction qui retourne l'inverse d'une couleur au format string de 6 chiffres hexadecimal,
	// par exemple si on envoi 'FF0000' cela retourne '00FFFF', une couleur est toujours au format RVB et pour l'inverser
	// il suffit de soustraire la valeur de chaque couleur au maximum possible dans chaque couleur.
	function inversecouleur($color) {
		// On prend les caract�res de la couleur $color deux par deux et
		// on les mets dans des variables
		$result = "";
			// On transforme les paires de 2 caract�res en d�cimal
			// On inverse chaque partie de la couleur en la soustrayant au maximum (255)
			// On remet chaque partie de la couleur en hexad�cimal
			// Si le nombre hexad�cimal ne prend qu'un caract�re (par exemple 'A') on le
			// transforme en '0A' car une couleur est toujours faite de 6 caract�res
			for ($i=0; $i < 6; $i+=2) {
				$valInverse = dechex(255 - hexdec($color[$i].$color[($i+1)]));
				$result = $result.((strlen($valInverse) == 2) ? $valInverse : "0".$valInverse);
			}

		// On retourne l'inverse de la couleur fournie $color
		return $result;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>CSS Dynamique</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css" media="all">
			body {
				width: 800px;
				height: 600px;
				margin: auto;
				font-family: Arial, "Arial Black", Georgia, "Times New Roman", Times, serif;
				background-color: <?php
									// La couleur de fond d'�cran est tir�e al�atoirement
									echo "#".couleuraleatoire();
								  ?>;
				}
			div{
				border: 1px black solid;
			}
			<?php
				// Cr�er des classes CSS avec des propri�t�s pour les DIV principaux et pour les DIV secondaires
				// Les DIV principaux ont des couleurs al�atoires et les DIV secondaires des couleurs inverses � ceux-ci
				for ($i=0; $i < nbrDIV; $i++) {
					$couleur = couleuraleatoire();
					$arrete = 800/7;

					echo '#div'.$i.'{';
					echo 'background-color: #'.$couleur.';';
					echo 'height: '.$arrete.'px;';
					echo 'width: '.$arrete.'px;';
					echo '}';
					echo '#div'.$i.'sec{';
					echo 'background-color: #'.inversecouleur($couleur).';';
					echo 'height: '.($arrete/2).'px;';
					echo 'width: '.($arrete/2).'px;';
					echo 'margin: '.($arrete/4).'px;';
					echo '}';
				}
			?>
		</style>
	</head>
	<body>
		<br />
		<table>
		<?php
			// Pour chaque DIV cr�er un autre DIV � l'int�rieur avec les bons ID en CSS
			$cpt = 0;
			for ($i=1; $i <= $nbrDivHauteur; $i++) {
				echo '<tr>';
				for ($y=1; $y <= $nbrDivLargeur; $y++) {
					echo '<td><div id="div'.$cpt.'"><div id="div'.$cpt.'sec"></div></div></td>';
					$cpt++;
				}
				echo '</tr>';
			}
			/*$time = new EvTimer(1,0, function (){

			});*/
		?>
	</table>
	</body>
</html>
