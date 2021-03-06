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
        return realpath(__DIR__."/../asset/media/");
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
            if ($this->endsWith($path, ".jpg")){
                return "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, ".jpeg")){
                return "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, "png")){
                return "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, "ico")){
                return "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, "mp4")){
                return "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, ".ico")){
                echo "$this->serverName/asset/media/$path";
            }
            if ($this->endsWith($path, ".js")){
                echo "<script src='$this->serverName/asset/js/$path'></script>";
            }
        }
        return 0;
    }
    function meta(){

    }
    private function startsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
    }

    private function endsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }

    function ping()
    {

    }
}
