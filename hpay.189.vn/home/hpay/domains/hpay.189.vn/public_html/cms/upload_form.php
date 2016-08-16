<?
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Files upload form</title>
    
    <style>
		body{
			font-family:Verdana, Arial, Helvetica, sans-serif;
			font-size:10px;
		}
        fieldset {
            width: 50%;
            margin: 15px 0px 25px 0px;
            padding: 15px;
        }
        legend {
            font-weight: bold;
        }
        .button {
            text-align: right;
        }
        .button input {
            font-weight: bold;
        }
    
    </style>
    
</head>

<body>
<?php

include('class.upload.php');
if ($_POST['action'] == 'multiple') {
    $files = array();
    foreach ($_FILES['my_field'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files)) 
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }
    foreach ($files as $file) {
        $handle = new Upload($file);
        if ($handle->uploaded) {
            $handle->Process("../uploads/videos/");
            if ($handle->processed) {
                echo '<fieldset style=\'width:300px\'>';
                echo '  <legend>file uploaded with success</legend>';
                echo '  <p>' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB</p>';
                echo '  link to the file just uploaded: <a href="http://vnf1luongyen.com.vn/uploads/videos/' . $handle->file_dst_name . '">http://vnf1luongyen.com.vn/uploads/videos/' . $handle->file_dst_name . '</a>';
                echo '</fieldset>';
            } else {
                echo '<fieldset>';
                echo '  <legend>file not uploaded to the wanted location</legend>';
                echo '  Error: ' . $handle->error . '';
                echo '</fieldset>';
            }
            
        } else {
        }
    }
    
}
?> 
    <fieldset style="width:300px">
        <legend>Multiple files upload</legend>
		Pick up some files, and press 'Upload now'
        <form name="form" enctype="multipart/form-data" method="post" action="">
            <input type="file" size="32" name="my_field[]" value="" /><br>
            <input type="file" size="32" name="my_field[]" value="" /><br>
            <input type="file" size="32" name="my_field[]" value="" /><br>
			<input type="file" size="32" name="my_field[]" value="" /><br>
			<input type="file" size="32" name="my_field[]" value="" /><br>
			<input type="file" size="32" name="my_field[]" value="" /><br>
            <input type="hidden" name="action" value="multiple" /><br>
            <input type="submit" name="Submit" value="Upload now" />
        </form>
    </fieldset>
</body>

</html>