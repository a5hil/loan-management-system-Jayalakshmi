<?php
/**
* Format Class - Date formatting, text formatting, Validation form data etc. 
*/
class Format{
	 public function formatDate($date){
	 	return date('F j, Y, g:i a', strtotime($date));
	 }

	 public function textShorten($text, $limit = 400){
		  $text = $text. " ";
		  $text = substr($text, 0, $limit);
		  $text = substr($text, 0, strrpos($text, ' '));
		  $text = $text."...";
		  return $text;
	 }

	 public function validation($data){
		  $data = trim($data);
                  
		  $data = stripcslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	if (is_array($item_description1)) {
      // Handle array case
      $trimmedArray = array_map('trim', $item_description1);
      return $trimmedArray;
    } else {
      // Handle string case
      return trim($item_description1);
    }
	 }
	 

	 public function title(){
		  $path = $_SERVER['SCRIPT_FILENAME'];
		  $title = basename($path, '.php');
		  //$title = str_replace('_', ' ', $title);
		  if ($title == 'index') {
		   $title = 'home';
		  }elseif ($title == 'contact') {
		   $title = 'contact';
		  }
		  return $title = ucfirst($title);
	 }

 //end of Format class
 }