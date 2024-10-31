<?php
class WelcomeController extends ApplicationController{
	function index(){
		$values = array();
		
		//Set data that we are going to send to the view
		$greetings = Array('Hello!',
												'Hi!',
												'Yo!',
												'Hey!');
		
		$values['greeting'] = $greetings[array_rand($greetings)];
		
		$this->values = $values;
	}
}
?>
