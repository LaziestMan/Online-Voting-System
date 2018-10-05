<?php

/**
 * Module class definition
 */
class ExpressCSV {

	public function importCSV($file, $cols) {
		if(file_exists($file)) {

			#file exists..
			#check for the extension (.csv)
			$fileName_chunk = explode('.', $file);
			if(strtolower($fileName_chunk[count($fileName_chunk)-1])!=='csv') {
				throw new Exception("!Invalid file format");
			} else {

				# Proceed ...
				$binary = fopen($file, 'r');
				$total = array();
				while(($csv = fgetcsv($binary, 0, ","))!==FALSE) {
					# Making it a row...
					$element = array();
					for($i=0;$i<$cols;$i++) {
						array_push($element, $csv[$i]);
					}

					array_push($total, $element);
				}
				fclose($binary);

				return $total;
				
			}

		} else {
			throw new Exception($file.": File Not Found", 1);
			
		}
	}
	
}
