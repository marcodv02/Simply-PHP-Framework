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
            'ъ'=>'-', 'Ь'=>'-', 'Ъ'=>'-', 'ь'=>'-',
            'Ă'=>'A', 'Ą'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
            'Þ'=>'B',
            'Ć'=>'C', 'ץ'=>'C', 'Ç'=>'C',
            'È'=>'E', 'Ę'=>'E', 'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
            'Ğ'=>'G',
            'İ'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
            'Ł'=>'L',
            'Ñ'=>'N', 'Ń'=>'N',
            'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
            'Ş'=>'S', 'Ś'=>'S', 'Ș'=>'S', 'Š'=>'S',
            'Ț'=>'T',
            'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
            'Ý'=>'Y',
            'Ź'=>'Z', 'Ž'=>'Z', 'Ż'=>'Z',
            'â'=>'a', 'ǎ'=>'a', 'ą'=>'a', 'á'=>'a', 'ă'=>'a', 'ã'=>'a', 'Ǎ'=>'a', 'а'=>'a', 'А'=>'a', 'å'=>'a', 'à'=>'a', 'א'=>'a', 'Ǻ'=>'a', 'Ā'=>'a', 'ǻ'=>'a', 'ā'=>'a', 'ä'=>'ae', 'æ'=>'ae', 'Ǽ'=>'ae', 'ǽ'=>'ae',
            'б'=>'b', 'ב'=>'b', 'Б'=>'b', 'þ'=>'b',
            'ĉ'=>'c', 'Ĉ'=>'c', 'Ċ'=>'c', 'ć'=>'c', 'ç'=>'c', 'ц'=>'c', 'צ'=>'c', 'ċ'=>'c', 'Ц'=>'c', 'Č'=>'c', 'č'=>'c', 'Ч'=>'ch', 'ч'=>'ch',
            'ד'=>'d', 'ď'=>'d', 'Đ'=>'d', 'Ď'=>'d', 'đ'=>'d', 'д'=>'d', 'Д'=>'D', 'ð'=>'d',
            'є'=>'e', 'ע'=>'e', 'е'=>'e', 'Е'=>'e', 'Ə'=>'e', 'ę'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'Ē'=>'e', 'Ė'=>'e', 'ė'=>'e', 'ě'=>'e', 'Ě'=>'e', 'Є'=>'e', 'Ĕ'=>'e', 'ê'=>'e', 'ə'=>'e', 'è'=>'e', 'ë'=>'e', 'é'=>'e',
            'ф'=>'f', 'ƒ'=>'f', 'Ф'=>'f',
            'ġ'=>'g', 'Ģ'=>'g', 'Ġ'=>'g', 'Ĝ'=>'g', 'Г'=>'g', 'г'=>'g', 'ĝ'=>'g', 'ğ'=>'g', 'ג'=>'g', 'Ґ'=>'g', 'ґ'=>'g', 'ģ'=>'g',
            'ח'=>'h', 'ħ'=>'h', 'Х'=>'h', 'Ħ'=>'h', 'Ĥ'=>'h', 'ĥ'=>'h', 'х'=>'h', 'ה'=>'h',
            'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'į'=>'i', 'ĭ'=>'i', 'ı'=>'i', 'Ĭ'=>'i', 'И'=>'i', 'ĩ'=>'i', 'ǐ'=>'i', 'Ĩ'=>'i', 'Ǐ'=>'i', 'и'=>'i', 'Į'=>'i', 'י'=>'i', 'Ї'=>'i', 'Ī'=>'i', 'І'=>'i', 'ї'=>'i', 'і'=>'i', 'ī'=>'i', 'ĳ'=>'ij', 'Ĳ'=>'ij',
            'й'=>'j', 'Й'=>'j', 'Ĵ'=>'j', 'ĵ'=>'j', 'я'=>'ja', 'Я'=>'ja', 'Э'=>'je', 'э'=>'je', 'ё'=>'jo', 'Ё'=>'jo', 'ю'=>'ju', 'Ю'=>'ju',
            'ĸ'=>'k', 'כ'=>'k', 'Ķ'=>'k', 'К'=>'k', 'к'=>'k', 'ķ'=>'k', 'ך'=>'k',
            'Ŀ'=>'l', 'ŀ'=>'l', 'Л'=>'l', 'ł'=>'l', 'ļ'=>'l', 'ĺ'=>'l', 'Ĺ'=>'l', 'Ļ'=>'l', 'л'=>'l', 'Ľ'=>'l', 'ľ'=>'l', 'ל'=>'l',
            'מ'=>'m', 'М'=>'m', 'ם'=>'m', 'м'=>'m',
            'ñ'=>'n', 'н'=>'n', 'Ņ'=>'n', 'ן'=>'n', 'ŋ'=>'n', 'נ'=>'n', 'Н'=>'n', 'ń'=>'n', 'Ŋ'=>'n', 'ņ'=>'n', 'ŉ'=>'n', 'Ň'=>'n', 'ň'=>'n',
            'о'=>'o', 'О'=>'o', 'ő'=>'o', 'õ'=>'o', 'ô'=>'o', 'Ő'=>'o', 'ŏ'=>'o', 'Ŏ'=>'o', 'Ō'=>'o', 'ō'=>'o', 'ø'=>'o', 'ǿ'=>'o', 'ǒ'=>'o', 'ò'=>'o', 'Ǿ'=>'o', 'Ǒ'=>'o', 'ơ'=>'o', 'ó'=>'o', 'Ơ'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
            'פ'=>'p', 'ף'=>'p', 'п'=>'p', 'П'=>'p',
            'ק'=>'q',
            'ŕ'=>'r', 'ř'=>'r', 'Ř'=>'r', 'ŗ'=>'r', 'Ŗ'=>'r', 'ר'=>'r', 'Ŕ'=>'r', 'Р'=>'r', 'р'=>'r',
            'ș'=>'s', 'с'=>'s', 'Ŝ'=>'s', 'š'=>'s', 'ś'=>'s', 'ס'=>'s', 'ş'=>'s', 'С'=>'s', 'ŝ'=>'s', 'Щ'=>'sch', 'щ'=>'sch', 'ш'=>'sh', 'Ш'=>'sh', 'ß'=>'ss',
            'т'=>'t', 'ט'=>'t', 'ŧ'=>'t', 'ת'=>'t', 'ť'=>'t', 'ţ'=>'t', 'Ţ'=>'t', 'Т'=>'t', 'ț'=>'t', 'Ŧ'=>'t', 'Ť'=>'t', '™'=>'tm',
            'ū'=>'u', 'у'=>'u', 'Ũ'=>'u', 'ũ'=>'u', 'Ư'=>'u', 'ư'=>'u', 'Ū'=>'u', 'Ǔ'=>'u', 'ų'=>'u', 'Ų'=>'u', 'ŭ'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ů'=>'u', 'ű'=>'u', 'Ű'=>'u', 'Ǖ'=>'u', 'ǔ'=>'u', 'Ǜ'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'У'=>'u', 'ǚ'=>'u', 'ǜ'=>'u', 'Ǚ'=>'u', 'Ǘ'=>'u', 'ǖ'=>'u', 'ǘ'=>'u', 'ü'=>'ue',
            'в'=>'v', 'ו'=>'v', 'В'=>'v',
            'ש'=>'w', 'ŵ'=>'w', 'Ŵ'=>'w',
            'ы'=>'y', 'ŷ'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Ŷ'=>'y',
            'Ы'=>'y', 'ž'=>'z', 'З'=>'z', 'з'=>'z', 'ź'=>'z', 'ז'=>'z', 'ż'=>'z', 'ſ'=>'z', 'Ж'=>'zh', 'ж'=>'zh'
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
            if ($this->endsWith($path, "svg")){
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
