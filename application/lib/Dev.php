<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


//settings
$name_of_shop = 'EShop'; //Название магазина
$logo_of_shop = '/public/images/Wikimedia-logo.png'; //Путь к логотипу магазина
$link_of_shop = 'http://oooop';
//



function debug($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}

function return_ip(){ //white list of ip`s
    $ips = array('46.219.229.198', '127.0.0.1');
    return $ips;
}

function translit($string){
    $translit = array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d',
        'е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'i','к'=>'k',
        'л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s',
        'т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh',
        'щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'',
        'А'=>'a','Б'=>'b','В'=>'v','Г'=>'G','Д'=>'d','Е'=>'e','Ё'=>'e',
        'Ж'=>'j','З'=>'z','И'=>'i','Й'=>'i','К'=>'k','Л'=>'l','М'=>'m',
        'Н'=>'n','О'=>'o','П'=>'p','Р'=>'r','С'=>'s','Т'=>'t','У'=>'u',
        'Ф'=>'f','Х'=>'h','Ц'=>'c','Ч'=>'ch','Ш'=>'sh','Щ'=>'shch',
        'Ы'=>'y','Э'=>'e','Ю'=>'yu','Я'=>'ya','Ъ'=>'','Ь'=>'');
    $replace_to_space = array( " ", "/",".");
    $replace_to_nothing = array(":","(",")");
    $string = str_replace($replace_to_nothing,"",$string);
    $string = str_replace($replace_to_space,"_",$string);
    $string = strtr($string,$translit);
    return $string;
}
function untransliterate($input){
    $gost = array(
        "a"=>"а","b"=>"б","v"=>"в","g"=>"г","d"=>"д","e"=>"е","yo"=>"ё",
        "j"=>"ж","z"=>"з","i"=>"и","i"=>"й","k"=>"к",
        "l"=>"л","m"=>"м","n"=>"н","o"=>"о","p"=>"п","r"=>"р","s"=>"с","t"=>"т",
        "y"=>"у","f"=>"ф","h"=>"х","c"=>"ц",
        "ch"=>"ч","sh"=>"ш","sh"=>"щ","i"=>"ы","e"=>"е","u"=>"у","ya"=>"я","A"=>"А","B"=>"Б",
        "V"=>"В","G"=>"Г","D"=>"Д", "E"=>"Е","Yo"=>"Ё","J"=>"Ж","Z"=>"З","I"=>"И","I"=>"Й","K"=>"К","L"=>"Л","M"=>"М",
        "N"=>"Н","O"=>"О","P"=>"П",
        "R"=>"Р","S"=>"С","T"=>"Т","Y"=>"Ю","F"=>"Ф","H"=>"Х","C"=>"Ц","Ch"=>"Ч","Sh"=>"Ш",
        "Sh"=>"Щ","I"=>"Ы","E"=>"Е", "U"=>"У","Ya"=>"Я","'"=>"ь","'"=>"Ь","''"=>"ъ","''"=>"Ъ","j"=>"ї","i"=>"и","g"=>"ґ",
        "ye"=>"є","J"=>"Ї","I"=>"І","_"=>" ",
        "YE"=>"Є"
    );
    return strtr($input, $gost);
}

function transliterate($input){
    $gost = array(
        " "=>"_","а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
        "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i",
        "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n",
        "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
        "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
        "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u",
        "я"=>"ya",
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
        "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch",
        "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U",
        "Я"=>"Ya",
        "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
        "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye",
        "Ї"=>"J","І"=>"I","Є"=>"YE",";"=>"_",":"=>"_"
    );
    //"_"=>" ",
    return strtr($input, $gost);
}
function shop_name(){
    global $name_of_shop;
    return $name_of_shop;
}
function shop_logo(){
    global $logo_of_shop;
    return $logo_of_shop;
}
function shop_link(){
    global $link_of_shop;
    return $link_of_shop;
}