<?php
	
	/**
	 * Klasse zum erstellen von Kreisdiagrammen
	 * @author adiko01
	 * @version 1.0
	 */
	class Kreisdiagramme {
		
		/**
		 * @param String $Dateiname Der Dateiname des Diagramms
		 * @param        $werte Array Die Werte <br>
		 *                            $WERTE = array( <br>
			 *                            &#09;&#09;"Katze" => array( <br>
			 *                            &#09;&#09;"value" => 100, <br>
			 *                            &#09;&#09;"color" => array(255, 255, 255)<br>
		 *                            &#09;)<br>
		 *                            );
		 * @param String $Schriftart Die Schriftart
		 * @param int    $breite Die Breite
		 * @param int    $hoehe Die Höhe
		 * @param int    $radius Der Radius
		 * @return void
		 * @since 1.0
		 */
		public function createKreisDiagramm(
											String $Dateiname,
											$werte,
											String $Schriftart,
											int $breite=400,
											int $hoehe = 300,
											int $radius = 200
		) {
			
			$start_x = ($breite/3)*2;
			$start_y = $hoehe/2;
			
			$rand_oben = 20;
			$rand_links = 20;
			$punktbreite = 10;
			$abstand = 10;
			$schriftgroesse = 10;
			
			$diagramm = imagecreatetruecolor($breite, $hoehe);
			
			$schwarz = imagecolorallocate($diagramm, 0, 0, 0);
			$weiss = imagecolorallocate($diagramm, 255, 255, 255);
			
			imagefill($diagramm, 0, 0, $weiss);
			
			$i = 0;
			$winkel = 0;
			arsort($werte);
			$gesamt = 0;
			foreach($werte as $key => $data) {
				$value = $data['value'];
				$gesamt = $gesamt + $value;
			}
			
			foreach($werte as $key => $data) {
				$i++;
				$start = $winkel;
				$value = $data['value'];
				$winkel = $start + $value*360/$gesamt;
				
				$color = imagecolorallocate($diagramm, $data['color'][0], $data['color'][1], $data['color'][2]);
				
				imagefilledarc($diagramm, $start_x, $start_y, $radius, $radius, $start, $winkel, $color, IMG_ARC_PIE);
				
				$unterkante = $rand_oben+$punktbreite+($i-1)*($punktbreite+$abstand);
				imagefilledrectangle($diagramm, $rand_links, $rand_oben+($i-1)*($punktbreite+$abstand), $rand_links+$punktbreite, $unterkante, $color);
				imagettftext($diagramm, $schriftgroesse, 0, $rand_links+$punktbreite+5, $unterkante-$punktbreite/2+$schriftgroesse/2, $schwarz, $Schriftart, $key." ".round($value*100/$gesamt, 0)." %");
			}
			
			imagepng($diagramm, $Dateiname);
		}
	}