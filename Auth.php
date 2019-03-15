<?php

/**
* 
*/
class Auth extends EncLibs
{
	
	 public function loadFile($name=false,$key=false)
	 { 	
	 	 
	 		$data = @file_get_contents("docs/{$name}");
	 	 	
	 		return $this->Decrypt($data , $key);
	 	
	}

	public function uploadBook($name=false,$data=false,$key=false)
	{
	 	 $filename = $name.".encrypted";
	 	 $filenamekey = $name.".key";
	 	 file_put_contents("docs/{$filename}", $this->Encrypt($data , $key));
	 	 file_put_contents("keys/{$filenamekey}", $key);
	}

	public function upload()
	{
		if(isset($_FILES["book"]) && isset($_POST["key"]))
		{
			$data = file_get_contents($_FILES["book"]["tmp_name"]);
			$this->uploadBook(substr(rand() , 0 , 4).'-'.$_FILES["book"]["name"],$data,$_POST["key"]);
		}
	}
}

?>