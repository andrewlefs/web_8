<?
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
</head>

<body>
  <?php
 
// we first include the upload class, as we will need it here to deal with the uploaded file
include('class.upload.php');

if ($_POST['action'] == 'multiple') {

    // ---------- MULTIPLE UPLOADS ----------

    // as it is multiple uploads, we will parse the $_FILES array to reorganize it into $files
    $files = array();
    foreach ($_FILES['my_field'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files)) 
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }

    // now we can loop through $files, and feed each element to the class
    foreach ($files as $file) {
    
        // we instanciate the class for each element of $file
        $handle = new Upload($file);
        
        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploaded) {

            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process("../uploads/download/");

            // we check if everything went OK
            if ($handle->processed) {
                // everything was fine !
                echo '<fieldset>';
                echo '  <legend>file uploaded with success</legend>';
                echo '  <p>' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB</p>';
                echo '  link to the file just uploaded: <a href="test/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
                echo '</fieldset>';
            } else {
                // one error occured
                echo '<fieldset>';
                echo '  <legend>file not uploaded to the wanted location</legend>';
                echo '  Error: ' . $handle->error . '';
                echo '</fieldset>';
            }
            
        } else {
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            echo '<fieldset>';
            echo '  <legend>file not uploaded on the server</legend>';
            echo '  Error: ' . $handle->error . '';
            echo '</fieldset>';
        }
    }
    
}

echo '<p><a href="index.html">do another test</a></p>';
?> 
</body>

</html>