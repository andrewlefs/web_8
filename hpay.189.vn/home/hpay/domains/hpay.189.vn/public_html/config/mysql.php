<?php

if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}

class db_sql
        {
	var $server     = "";
	var $database   = "";
	var $username   = "";
	var $password   = "";
	var $serverconn         = 0;
        var $dbconn             = 0;
        var $query_id           = 0;
        var $result             = array();
        var $query_count        = 0;
        var $insert_id          = 0;
        var $number             = 0;	

    function db_sql(){
            global $server, $database, $username, $password;
    if ( !isset($server)||!isset($database)||!isset($username)||!isset($password) )
            {
           $this->halt("Not exist database's information: database host, database name,...");
    }
    $this->server = $server;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    }
    function db_connect(){
            $this->serverconn = mysql_connect($this->server,$this->username,$this->password);
            if ( ! $this->serverconn)  
            {
                    $this->halt("Couldn't connect to database:".$this->databases);
                    return;
            }
            @mysql_query("SET NAMES utf8",$this->serverconn);
    }
    function backup() {
     $backup = $this->backups.'/'.$this->db_name.'_backup_'.date('Y').'_'.date('m').'_'.date('d').'.sql';
     $cmd = "mysqldump --opt -h $this->server -p $this->password -u $this->username $this->database > $backup";
     try {
         system($cmd);
         return $this->encode('Error',false,'Backup Successfuly Complete');
     } catch(PDOException $error) {
         return $this->encode('Error',true,$error->getMessage());
     }
 }
    function db_select($db=""){
        if ( $db!="" ) $this->database=$db;
    $this->dbconn = mysql_select_db($this->database,$this->serverconn)  or  $this->halt("Couldn't use this database:". $this->databases);
}
    function query($query_str=""){
    if ( $query_str!="" ){
            $this->query_id = mysql_query($query_str) or $this->halt("Couldn't query this query string: ".$query_str);
            $this->query_count++;
    }
    return $this->query_id;
}
    function fetch_array($query_id=-1){
            if ( $query_id!=-1 ) $this->query_id=$query_id;
            $this->result = mysql_fetch_array($this->query_id);
             return $this->result;
}
    function check_del($query_id=-1){
    if ( $query_id!=-1 ) $this->query_id=$query_id;
    return mysql_affected_rows(); 
}
    function num_rows($query_id=-1){
                 if ( $query_id!=-1 ) $this->query_id=$query_id;
                 return mysql_num_rows($this->query_id);
    }
    
    
      function fetch_rows($table_name,$field,$dk){
            $sql_query = "select count(*) from $table_name where ".$field."='$dk'";
           $a_tv_1=mysql_query($sql_query);
            return mysql_fetch_row($a_tv_1);	 
}

    function count_rows($table_name){
    $sql_query = "SELECT * FROM $table_name ";
            $this->query($sql_query); 
            return $this->num_rows();	 
}
    function count_rows_from_query($sql_query){
            $this->query($sql_query); 
            return $this->num_rows();	 
}	
    function check_exist($fromtable,$checkname,$checkvalue){
    	$sql_query = "SELECT * FROM $fromtable WHERE $checkname='". $checkvalue ."'";
  	    $this->query($sql_query);
    	if ( $this->num_rows()>0 ) return 1;
        	return 0;
    }
    function insert_id(){
    	$this->insert_id = mysql_insert_id();
   		return $this->insert_id;
  	}
    function get_counter(){
            $select = "SELECT counter FROM kien_sysop";
            $res = $this->fetch_array($this->query($select));
            return $res["counter"];
    }
    function last_counter($get){
            $get = $get + 1;
            $update_counter = "UPDATE kien_sysop SET counter = $get";
            $this->query($update_counter);
    }		
    function close(){
    	return mysql_close($this->serverconn);
    }
    function halt($msg){
    	echo "<center><b>ERROR</b></center><br/>";
 echo $msg;
        echo "L&#7895;i khi th&#7921;c thi c&acirc;u l&#7879;nh SQL. Xin b&aacute;o cho admin bi&#7871;t v&#7873; l&#7895;i n&agrave;y. Xin c&#7843;m &#417;n!<br><a href='javascript:history.back();'>Back</a>";
        die();
  	}	

}
?>