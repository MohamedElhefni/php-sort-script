<?php
if (PHP_SAPI === 'cli') {
	$dir = empty($argv[1]) ? './' : (is_dir($argv[1]) ? $argv[1] : './'); // get directory from cli (user )

	/**
	 * functtion to move file into folder
	 *
	 * @param String $fileName
	 * @param String $folderName
	 * @return void
	 */
	function move($fileName, $folderName)
	{
		global $dir;
		return rename($dir . "/$fileName", $dir . "/{$folderName}/{$fileName}");
	}

	/**
	 * Get File Extenstion
	 *
	 * @param String $value
	 * @return String $ext
	 */
	function getExt($value)
	{
		return pathinfo($value, PATHINFO_EXTENSION); // get ext
	}

	/**
	 * function to sort file
	 *
	 * @param arr $files
	 * @param String $folder
	 * @param String $ext
	 * @return void
	 */
	function sortFiles($files, $folder, $ext)
	{
		foreach ($files as $file) {
			if ($file != 'sort.php') {
				if (getExt($file) == $ext) {
					move($file, $folder); // move the file into folder 
					echo "\e[32m {$file} \033[0m Moved Successfully" . "\n"; // make green color 
				}
			}
		}
	}


	$files = scandir($dir); // get all files from the dir 
	$exts = array_map(function ($value) { // apply function getExt for each element in array of files to get ext
		return getExt($value);
	}, $files);



	$uniqueExts = array_filter(array_unique($exts)); // remove repeated and null values from array 
	foreach ($uniqueExts as $ext) {
		$folder = "{$ext}Folder"; //folder name extends on ext 
		if (file_exists($folder)) { // check if folder exists 
			sortFiles($files, $folder, $ext); // sort files if folder exists and move files into the folders 
		} else {
			@mkdir($dir . $folder); // make if isn't exists
			echo "\e[33m {$folder} \033[0m Created Successfully" . "\n"; // make it with orange color
			sortFiles($files, $folder, $ext); // sort the files 
		}
	}
}
