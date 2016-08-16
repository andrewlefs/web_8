<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	session_start();
	// get counter when client visited your website.
	if(!session_is_registered("visited")){
		session_register("visited");
		$get_counter = $sql->get_counter(); 
		$sql->last_counter($get_counter);
	}
	
// get user online
	$num_rows = $sql->check_exist(DB_PREFIX."sessions","session_ip",getenv("REMOTE_ADDR"));
	if($num_rows==1){
		$update_query = "UPDATE kien_sessions SET session_start = ".time()." WHERE session_ip = '".getenv("REMOTE_ADDR")."'";		
		$sql->query($update_query);
	}
	else{
		$insert_query = "INSERT INTO kien_sessions(session_start, session_ip) VALUES(".time().",'".getenv("REMOTE_ADDR")."')";		
		$sql->query($insert_query);
	}
	// Delete expired sessions
	$time_expired = 30; // in seconds
	$time_out = time() - $time_expired;
	$delete_query = "DELETE FROM kien_sessions WHERE session_start < $time_out";
	$sql->query($delete_query);
	$user_online = $sql->count_rows("kien_sessions");
	$sql->close();
	
?>