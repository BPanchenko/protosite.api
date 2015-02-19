<?php
	
	function translit($string) {
		$trans = array("а" => "a", "б" => "b", "в" => "v", "г" => "g",
						"д" => "d", "е" => "e", "ё" => "e", "ж" => "zh",
						"з" => "z", "и" => "i", "й" => "y", "к" => "k",
						"л" => "l", "м" => "m", "н" => "n", "о" => "o",
						"п" => "p", "р" => "r", "с" => "s", "т" => "t",
						"у" => "u", "ф" => "f", "х" => "kh", "ц" => "ts",
						"ч" => "ch", "ш" => "sh", "щ" => "shch", "ы" => "y",
						"э" => "e", "ю" => "yu", "я" => "ya", "А" => "A",
						"Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
						"Е" => "E", "Ё" => "E", "Ж" => "Zh", "З" => "Z",
						"И" => "I", "Й" => "Y", "К" => "K", "Л" => "L",
						"М" => "M", "Н" => "N", "О" => "O", "П" => "P",
						"Р" => "R", "С" => "S", "Т" => "T", "У" => "U",
						"Ф" => "F", "Х" => "Kh", "Ц" => "Ts", "Ч" => "Ch",
						"Ш" => "Sh", "Щ" => "Shch", "Ы" => "Y", "Э" => "E",
						"Ю" => "Yu", "Я" => "Ya", "ь" => "", "Ь" => "",
						"ъ" => "", "Ъ" => "");
		return preg_match("/[а-яА-Я]/",$string) ? strtr($string, $trans) : $string;
	}
	
	function str2array($data) {
		if(!empty($data)) {
				$str = str_replace(array(';','\t','\n'),',',$data);
				$str = preg_replace('~[^-_a-z0-9,]+~u','',$str);
				$array = explode(',',$str);
				if(!is_array($array) && !empty($array)) $array[0] = $array;
		} elseif(is_array($data)) $array = $data;
		else $array = NULL;
		return $array;
	}
	
	function __autoload($classname) {
		$filename = ucfirst($classname);
		
		$dir = "classes/";
		if(strpos($classname, 'View') !== false)
			$dir = "views/";
		if(strpos($classname, 'Model') !== false)
			$dir = "models/";
		if(strpos($classname, 'Collection') !== false)
			$dir = "collections/";
		
		$path = str_replace('.:','',get_include_path())."/";
		$file = $path . $dir . $filename .".php";
		
		if(is_file($file))
			include_once $file;
	}
?>