<?php
require_once("database_config.php");
require_once('class/class.MySQL.php');
class insert{
	var $sql;
	function __construct(){
		$this->sql = new MySQL(DBName,DBUser,DBPassword,"",HostName);
	}

	//insert new department
	function insertDepartment($dep){
		return $this->sql->Insert(array("department"=>$dep), "departments");
	}

	//insert new chat when guest request chat support.
	function insertChat($atts=array()){
		$this->sql->Insert(array(
				"datetime"=>time(),
				"department"=>$atts["department"],
				"email"=>$atts["email"],
				"mobile"=>$atts["mobile"],
				"website"=>$atts["website"],
				"status"=>1,
				"name"=>$atts["name"],
				"accepted"=>0,
				"newmessage"=>0,
				"requested"=>0
		), "chats");
		return $this->sql->LastInsertID();
	}

	//insert guest information
	function insertGuest(){
		static $country;
		static $city;
		static $ip_address;
		static $id;
		$ip_address = $_SERVER["REMOTE_ADDR"];
		$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip_address));

		if($ip_data && $ip_data->geoplugin_countryName != null)
		{
			$country = $ip_data->geoplugin_countryName;
			$city = $ip_data->geoplugin_regionName;
		}
		if($this->sql->CountRows("guests", array("ipaddress"=>$ip_address))>0){
			$this->sql->Update("guests",array("new"=>0),array("ipaddress"=>$ip_address));
			$query = $this->sql->ExecuteSQL("SELECT id FROM guests WHERE ipaddress='{$ip_address}'");
			return $query["id"];
		}else{
			$this->sql->Insert(array(
					"ipaddress"	=>($ip_address?$ip_address:rand()),
					"useragent"	=>($_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:"unavailable"),
					"country"	=>$country,
					"city"		=>$city,
					"datetime"	=>time(),
					"referrer"	=>($_SERVER["HTTP_REFERER"]!=null?$_SERVER["HTTP_REFERER"]:"unavailable"),
					"url"		=>($_SERVER["QUERY_STRING"]?$_SERVER["QUERY_STRING"]:"unavailable"),
					"new"=>1
			), "guests");
			return $this->sql->LastInsertID();
		}
	}

	//insert chat message by admin user or guest
	function sendMessage($atts=array()){
		$atts+=array("datetime"=>time());
		return $this->sql->Insert($atts,"chathistory");
	}
}