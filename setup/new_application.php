<?php
print getPurpleColoredString("8888888b.                            888     \n");
print getPurpleColoredString("888   Y88b                           888     \n");
print getPurpleColoredString("888    888                           888     \n");
print getPurpleColoredString("888   d88P .d88b.   .d88b.   .d8888b 88888b. \n");
print getPurpleColoredString("8888888P\" d88\"\"88b d88\"\"88b d88P\"    888 \"88b\n");
print getPurpleColoredString("888       888  888 888  888 888      888  888\n");
print getPurpleColoredString("888       Y88..88P Y88..88P Y88b.    888  888\n");
print getPurpleColoredString("888        \"Y88P\"   \"Y88P\"   \"Y8888P 888  888\n");
print "\n";
print getCyanColoredString("Building initial blank project...");

recurse_copy(realpath(__DIR__ . '/base/'),realpath(__DIR__ . '/../../../../'));
print getCyanColoredString(" Finished!\n\n");
print getLightCyanColoredString("Welcome to the Dog Pound!!!\n");

function getCyanColoredString($string) {
	return getColoredString($string, '0;36');
}

function getLightCyanColoredString($string) {
	return getColoredString($string, '1;36');
}

function getGreenColoredString($string) {
	return getColoredString($string, '0;33');
}

function getPurpleColoredString($string) {
	return getColoredString($string, '0;35');
}

function getColoredString($string, $color_code) {
	$colored_string = "";
	$colored_string .= "\033[".$color_code."m";
	
	// Add string and end coloring
	$colored_string .=  $string . "\033[0m";
	
	return $colored_string;
}

function recurse_copy($src,$dst) { 
	$dir = opendir($src); 
	@mkdir($dst); 
	while(false !== ( $file = readdir($dir)) ) { 
		if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) { 
				recurse_copy($src . '/' . $file,$dst . '/' . $file); 
			}else{
				copy($src . '/' . $file,$dst . '/' . $file); 
			} 
		} 
	} 
	closedir($dir); 
}
?>