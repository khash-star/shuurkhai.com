<?
if(isset($_FILES['upload'])){
  // ------ Process your file upload code -------
        $filen = $_FILES['upload']['tmp_name']; 
		$suffix = date("ymdhis");
        $con_images = $suffix.$_FILES['upload']['name'];
		
        move_uploaded_file($filen, $con_images );
		if(strpos($_SERVER['HTTP_HOST'],'www')===false)
			{
				$url = 'https://shuurkhai.com/';
			}
			else
			{
				$url = 'https://www.shuurkhai.com/';
			}
       $url .= "assets/uploads/".$suffix.$_FILES['upload']['name'];
   $funcNum = $_GET['CKEditorFuncNum'] ;
   // Optional: instance name (might be used to load a specific configuration file or anything else).
   $CKEditor = $_GET['CKEditor'] ;
   // Optional: might be used to provide localized messages.
   $langCode = $_GET['langCode'] ;
    
   // Usually you will only assign something here if the file could not be uploaded.
   $message = '';
   echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}
?>