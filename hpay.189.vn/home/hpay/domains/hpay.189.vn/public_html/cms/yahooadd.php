<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();		

	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "yahoo"){
		if(!session_register('countadd')){
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		//lay thong tin ve cac danh muc				
		$yahooname 	= isset($_POST["yahooname"])	? convert_font($_POST["yahooname"])	: '';
		$nickname 	= isset($_POST["nickname"])	? convert_font($_POST["nickname"])	: '';		
		$thutu 		= isset($_POST["thutu"]) 	? $_POST["thutu"]			: 1;				
		
		if($yahooname 	== "") $message1 = $message1."Hãy nhập tên nick yahoo";				
		if($nickname 	== "") $message1 = $message1."Hãy nhập nick name";
		$n = $sql->count_rows(DB_PREFIX."yahoo") + 1;
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$yahooname 	= isset($_POST["yahooname"])	? convert_font($_POST["yahooname"],2)		: '';
			$nickname 	= isset($_POST["nickname"])	? convert_font($_POST["nickname"],2)		: '';
			$insert_query = "INSERT INTO ".DB_PREFIX."yahoo(yahooname, nickname, thutu) ";
			$insert_query = $insert_query." VALUES('$yahooname', '$nickname', $thutu)";
			if($sql->query($insert_query)){			
				unset($yahooname, $nickname);	
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;				
				$message 	= "Nick name thứ ".$HTTP_SESSION_VARS['countadd']." đã được thêm vào CSDL.";							
			}		
			$n = $sql->count_rows(DB_PREFIX."yahoo") + 1;										
			$sql->close();	
		}
	}else{			
			$n = $sql->count_rows(DB_PREFIX."yahoo") + 1;
			$sql->close();
	}		
?>
<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=yahoo">Yahoo</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='warning'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Yahoo</h1>
      
      <form action="index.php?pages=yahoo&mode=add" method="post" enctype="multipart/form-data" name="addyahoo" id="addyahoo">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
      <div id="tab-general">
        <div id="language1">
            <table class="form">
              <tr>
                <td><span class="required">*</span>Yahoo name:</td>
                <td><input type="text" name="yahooname" size="40"  value="<?=$yahooname?>" />
                  </td>
              </tr>
                <tr>
                <td><span class="required">*</span>Nick name:</td>
                <td><input type="text" name="nickname" size="40"  value="<?=$nickname?>" />
                  </td>
              </tr>
               <tr>
                <td><span class="required">*</span>Sort Order:</td>
                <td>
                        <SELECT name=thutu size=1 id="thutu">
                        <?php  
                             for($i=1; $i<$n+1; $i++) 
                             {
                                    if ($i == 1){
                             ?>
                      <OPTION value=<?=$i?> selected>
                      <?=$i?>
                      </OPTION>
                      <?php }else { ?>
                      <OPTION value=<?=$i?>>
                      <?=$i?>
                      </OPTION>
                      <?php }}?>
                    </SELECT>
                  </td>
              </tr>
            </table>
          </div>
       </div>
        <input name="pages" type="hidden" id="pages" value="yahoo">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>
