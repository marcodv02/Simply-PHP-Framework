<?php

class Background{
    private $begin_path= "/".SERVERNAME;
    private $db;
    private $table= "";
    private $sql;
    function __construct(){
        $this->db= new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    function pong(){

    }
    function edit($filter, $data, $table){
        $table= ($table) ? $table : $this->table;

        $sql= "UPDATE $table SET ";

        foreach ($data as $column=>$value){
            $sql.= "$column='$value',";
        }
        $sql= rtrim($sql, ",")." WHERE $filter;";
        $this->sql= $sql;
        $this->db->query($sql);

        return mysqli_affected_rows($this->db);
    }
    function insert($data, $table= ""){
        $table= ($table) ? $table : $this->table;

        $sql= "INSERT INTO $table ";

        $keys= "(";
        $values= "(";
        foreach ($data as $key=>$val){
            $keys.= "$key,";
            $values.= "'$val',";
        }
        $keys= rtrim($keys, ",").")";
        $values= rtrim($values, ",").")";

        $sql.= "$keys VALUES $values;";
        if ($this->db->query($sql)){
            $ret= 1;
        }else{
            $ret= 0;
        }
        $this->sql= $sql;
        return $ret;
    }
    function show_all($filter, $table=""){
        $table= ($table) ? $table : $this->table;
        $filter= ($filter) ? "WHERE $filter" : "";

        $sql= "SELECT * FROM $table $filter;";

        return $this->query($sql);
    }
    function query($sql){
        if ($res= $this->db->query($sql)){
            $ret= $res->fetch_all(MYSQLI_ASSOC);
        }else{
            $ret= False;
        }

        $this->sql= $sql;
        return $ret;
    }
    function num_select($filter, $table=""){
        return count($this->show_all($filter, $table));
    }
    function get_last_query(){
        return $this->sql;
    }
    function set_table($tab){
        $this->table= $tab;
    }
    function __destruct(){
        $this->db->close();
    }
    function upload_dir(){
        return realpath(__DIR__."/../asset/media/piatti/");
    }
    function no_accent($str){
        /**
         * Replace language-specific characters by ASCII-equivalents.
         * @param string $s
         * @return string
         */

        /*$replace = array(
            '??'=>'-', '??'=>'-', '??'=>'-', '??'=>'-',
            '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'Ae',
            '??'=>'B',
            '??'=>'C', '??'=>'C', '??'=>'C',
            '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'E',
            '??'=>'G',
            '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'I',
            '??'=>'L',
            '??'=>'N', '??'=>'N',
            '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'Oe',
            '??'=>'S', '??'=>'S', '??'=>'S', '??'=>'S',
            '??'=>'T',
            '??'=>'U', '??'=>'U', '??'=>'U', '??'=>'Ue',
            '??'=>'Y',
            '??'=>'Z', '??'=>'Z', '??'=>'Z',
            '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'ae', '??'=>'ae', '??'=>'ae', '??'=>'ae',
            '??'=>'b', '??'=>'b', '??'=>'b', '??'=>'b',
            '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'c', '??'=>'ch', '??'=>'ch',
            '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'d', '??'=>'D', '??'=>'d',
            '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e',
            '??'=>'f', '??'=>'f', '??'=>'f',
            '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g', '??'=>'g',
            '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h', '??'=>'h',
            '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'ij', '??'=>'ij',
            '??'=>'j', '??'=>'j', '??'=>'j', '??'=>'j', '??'=>'ja', '??'=>'ja', '??'=>'je', '??'=>'je', '??'=>'jo', '??'=>'jo', '??'=>'ju', '??'=>'ju',
            '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k', '??'=>'k',
            '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l', '??'=>'l',
            '??'=>'m', '??'=>'m', '??'=>'m', '??'=>'m',
            '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n', '??'=>'n',
            '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'oe', '??'=>'oe', '??'=>'oe',
            '??'=>'p', '??'=>'p', '??'=>'p', '??'=>'p',
            '??'=>'q',
            '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r', '??'=>'r',
            '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'s', '??'=>'sch', '??'=>'sch', '??'=>'sh', '??'=>'sh', '??'=>'ss',
            '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '??'=>'t', '???'=>'tm',
            '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'ue',
            '??'=>'v', '??'=>'v', '??'=>'v',
            '??'=>'w', '??'=>'w', '??'=>'w',
            '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y', '??'=>'y',
            '??'=>'y', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'z', '??'=>'zh', '??'=>'zh'
        );
        return strtr($str, $replace);*/
        return iconv('UTF-8','ASCII//TRANSLIT',$str);
    }
}
class Dish{
    public $quantity= 0;
    public $note= "";
    function __construct($qty, $note){
        $this->quantity= $qty;
        $this->note= $note;
    }
}
class Ordine{
    private $dishes= [];
    function get_dishes(){
        /*$arr= [];
        foreach ($this->dishes as $k=>$dish)
            $arr[]= $dish;
        */
        $obj= [];
        foreach ($this->dishes as $code=>$a) {
            $arr = [];
            foreach ($a as $dish)
                $arr[]= $dish;
            $obj[$code]= $arr;
        }
        return $obj;
    }
    function str_get_dishes(){
        $string= "";
        foreach ($this->dishes as $code=>$dishes){
            foreach ($dishes as $dish){
                $string.= "$code:$dish->quantity\n";
                if ($dish->note!="")
                    $string.= "note: $dish->note\n";
            }
        }
        return $string;
    }

    function get_dish_pos($code, $note){
        if (isset($this->dishes[$code])&&is_array($this->dishes[$code])){
            foreach ($this->dishes[$code] as $k=>$dish)
                if ($dish->note==$note)
                    return $k;
                /*
            for ($i= 0; $i<count($this->dishes[$code]); $i++) {
                if (isset($this->dishes[$code][$i])&&($this->dishes[$code][$i])&&($this->dishes[$code][$i]->note == $note))
                    return $i;
            }*/
        }
        return -1;
    }
	function get_with_notes($code){
		$arr= [];
		foreach ($this->dishes[$code] as $dish){
			$arr[$dish->note]= $dish->quantity;
		}
		return $arr;
	}
    function get($code, $pos=-1){
        if ($pos==-1)
            return $this->dishes[$code];
        else
            return $this->dishes[$code][$pos];
    }
    function get_dish_quantity($code){
        $n= 0;
        foreach ($this->dishes[$code] as $dish)
            $n+= $dish->quantity;
        return $n;
    }
    function exist($code){
        return isset($this->dishes[$code]);
    }
    function clear(){
        $this->dishes= [];
    }
    function append($dishes){
        foreach ($dishes as $code=>$dish){
            foreach ($dish as $dish_obj)
                $this->add($code, $dish_obj, true);
        }
    }
    function add($code, $dish, $clone=false){
        if (isset($this->dishes[$code])){
            $pos= $this->get_dish_pos($code, $dish->note);
            if ($pos!=-1)
                $this->dishes[$code][$pos]->quantity+= $dish->quantity;
            else
                $this->dishes[$code][]= ($clone) ? clone $dish : $dish;
                //array_push($this->dishes[$code], $dish);
        }
        else
        {
            if ($clone) {
                $tmp = clone $dish;
                $this->dishes[$code] = [$tmp];
            }else
                $this->dishes[$code]= [$dish];
        }
    }
    function remove($code, $dish){
        if (isset($this->dishes[$code])){
            $pos= $this->get_dish_pos($code, $dish->note);
            if ($pos!=-1)
                if ($this->dishes[$code][$pos]->quantity>1)
                    $this->dishes[$code][$pos]->quantity-= 1;
                else {
                    unset($this->dishes[$code][$pos]);
                    if (count($this->dishes[$code])==0)
                        unset($this->dishes[$code]);
                }
        }
        return [$code, $dish->note, $this->get_dish_pos($code, $dish->note)];
    }
}
class Foreground{
    private $serverName= "/".SERVERNAME;
    private $begin_path= "/".SERVERNAME."/view/";

    function view($path){
        $path= realpath($_SERVER['DOCUMENT_ROOT'].$this->begin_path.$path.".php");
        if ($path){
            if ((include $path)==FALSE)
                var_dump("Error to include page");
        }else{
            var_dump("Page doesn't exist");
        }
    }
    function api($path){
        $path= realpath($_SERVER['DOCUMENT_ROOT'].$this->serverName."/api/".$path.".php");
        header('Content-type: application/json');
        if ($path){
            if ((include $path)==FALSE)
                var_dump("Error to include page");
        }else{
            var_dump("Page doesn't exist");
        }
    }
    function element($path){
        $path= realpath($_SERVER['DOCUMENT_ROOT'].$this->serverName."/element/".$path.".php");

        if ($path){
            if ((include $path)==FALSE)
                var_dump("Error to include page");
        }else{
            var_dump("Element doesn't exist");
        }
    }
    function lang(){
        echo "it";
    }
    function title($name){
        echo "<title>$name</title>";
    }
    function asset($path, $data=[]){
        $format= "";
        foreach ($data as $point=>$value){
            $format.= $point."='".$value."' ";
        }

        if ($this->startsWith($path, "http")){
            if ($this->endsWith($path, ".js")){
                echo "<script src='$path' $format></script>";
            }
            if ($this->endsWith($path, ".css")){
                echo "<link href='$path' $format rel='stylesheet'/>";
            }
        }else{
            if ($this->endsWith($path, ".css")){
                echo "<link href='$this->serverName/asset/css/$path' rel='stylesheet'/>";
            }
            if ($this->endsWith($path, ".js")){
                echo "<script src='$this->serverName/asset/js/$path'></script>";
            }
            if ($this->endsWith($path, [".jpg", ".jpeg", ".png", ".svg", ".ico", ".mp4"])){
                return "$this->serverName/asset/media/$path";
            }
        }
        return 0;
    }
    function meta(){

    }
    private function startsWith( $haystack, $needle ) {
        if (is_array($needle)){
            foreach ($needle as $need){
                $length = strlen($need);
                if (substr( $haystack, 0, $length )===$need)
                    return true;
            }
        }else{
            $length = strlen( $needle );
            return substr( $haystack, 0, $length ) === $needle;
        }
        return false;
    }

    private function endsWith( $haystack, $needle ) {
        if (is_array($needle)){
            foreach ($needle as $need){
                $length = strlen($need);
                if (substr( $haystack, 0, -$length )===$need)
                    return true;
            }
        }else{
            $length = strlen( $needle );
            return substr( $haystack, 0, -$length ) === $needle;
        }
        return false;
    }

    function ping()
    {

    }
}
