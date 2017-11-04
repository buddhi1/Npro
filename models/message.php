<?php 
/**
* Message model class
*/
class Message
{
	//public attributes to access class attributes using arrow operator
	public $id;
	public $text;
	public $seId;
	public $recId;
	
	function __construct($id, $text, $seId, $recId, $created_at)	
	{
		$this->id = $id;
		$this->text = $text;
		$this->seId = $seId;
		$this->recId = $recId;
		$this->created_at = $created_at;
	}
}
?>