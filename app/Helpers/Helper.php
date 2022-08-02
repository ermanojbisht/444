<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Carbon\Carbon;
use Log;
use Auth;
use Spatie\Browsershot\Browsershot; //this is for testing purpose.
class Helper
{
	/**
	 * @param string $url
	 * @return ee/ce/se or other
	 */
	public static function urltype($url)
	{
		$segment = explode('/', $url);
		if (count($segment) >= 6) {
			switch ($segment[5]) {
				case 'ee':
					$type = 'ee' . $segment[6];
					break;
				case 'se':
					$type = 'se' . $segment[6];
					break;
				case 'ce':
					$type = 'ce' . $segment[6];
					break;
				default:
					$type = 'all';
					break;
			}
		} else {
			$type = 'all';
		}
		return $type;
	}

	public static function timeStart()
	{
		return $time_start = microtime(true);
	}

	public static function showTime($t1, $t2, $d = '')
	{
		$time = $t2 - $t1;
		echo "\n </br>$d Time taken in $time seconds</br>\n";
	}

	public static function flattenArray($array)
	{

		if (is_array($array)) {

			$flat = array();
			$flat = $array[key($array)];
			return $flat;
		} else {
			return false;
		}
	}

	public function krutidevChracter()
	{
		return array(
			// "(",")",
			"ñ", "Q+Z", "sas", "aa", ")Z", "ZZ", "‘", "’", "“", "”",

			"å", "ƒ", "„", "…", "†", "‡", "ˆ", "‰", "Š", "‹",

			"¶+", "d+", "[+k", "[+", "x+", "T+", "t+", "M+", "<+", "Q+", ";+", "j+", "u+",
			"Ùk", "Ù", "ä", "–", "—", "é", "™", "=kk", "f=k",

			"à", "á", "â", "ã", "ºz", "º", "í", "{k", "{", "=", "«",
			"Nî", "Vî", "Bî", "Mî", "<î", "|", "K", "}",
			"J", "Vª", "Mª", "<ªª", "Nª", "Ø", "Ý", "nzZ", "æ", "ç", "Á", "xz", "#", ":",

			"v‚", "vks", "vkS", "vk", "v", "b±", "Ã", "bZ", "b", "m", "Å", ",s", ",", "_",

			"ô", "d", "Dk", "D", "[k", "[", "x", "Xk", "X", "Ä", "?k", "?", "³",
			"pkS", "p", "Pk", "P", "N", "t", "Tk", "T", ">", "÷", "¥",

			"ê", "ë", "V", "B", "ì", "ï", "M+", "<+", "M", "<", ".k", ".",
			"r", "Rk", "R", "Fk", "F", ")", "n", "/k", "èk", "/", "Ë", "è", "u", "Uk", "U",

			"i", "Ik", "I", "Q", "¶", "c", "Ck", "C", "Hk", "H", "e", "Ek", "E",
			";", "¸", "j", "y", "Yk", "Y", "G", "o", "Ok", "O",
			"'k", "'", "\"k", "\"", "l", "Lk", "L", "g",

			"È", "z",
			"Ì", "Í", "Î", "Ï", "Ñ", "Ò", "Ó", "Ô", "Ö", "Ø", "Ù", "Ük", "Ü",

			"‚", "ks", "kS", "k", "h", "q", "w", "`", "s", "S",
			"a", "¡", "%", "W", "•", "·", "∙", "·", "~j", "~", "\\", "+", " ः",
			"^", "*", "Þ", "ß", "(", "¼", "½", "¿", "À", "¾", "A", "-", "&", "&", "Œ", "]", "~ ", "@"
		);
	}

	public function unicodeCharacter()
	{
		return array(
			//"¼","½",
			"॰", "QZ+", "sa", "a", "र्द्ध", "Z", "\"", "\"", "'", "'",

			"०", "१", "२", "३", "४", "५", "६", "७", "८", "९",

			"फ़्", "क़", "ख़", "ख़्", "ग़", "ज़्", "ज़", "ड़", "ढ़", "फ़", "य़", "ऱ", "ऩ", // one-byte nukta varNas
			"त्त", "त्त्", "क्त", "दृ", "कृ", "न्न", "न्न्", "=k", "f=",

			"ह्न", "ह्य", "हृ", "ह्म", "ह्र", "ह्", "द्द", "क्ष", "क्ष्", "त्र", "त्र्",
			"छ्य", "ट्य", "ठ्य", "ड्य", "ढ्य", "द्य", "ज्ञ", "द्व",
			"श्र", "ट्र", "ड्र", "ढ्र", "छ्र", "क्र", "फ्र", "र्द्र", "द्र", "प्र", "प्र", "ग्र", "रु", "रू",

			"ऑ", "ओ", "औ", "आ", "अ", "ईं", "ई", "ई", "इ", "उ", "ऊ", "ऐ", "ए", "ऋ",

			"क्क", "क", "क", "क्", "ख", "ख्", "ग", "ग", "ग्", "घ", "घ", "घ्", "ङ",
			"चै", "च", "च", "च्", "छ", "ज", "ज", "ज्", "झ", "झ्", "ञ",

			"ट्ट", "ट्ठ", "ट", "ठ", "ड्ड", "ड्ढ", "ड़", "ढ़", "ड", "ढ", "ण", "ण्",
			"त", "त", "त्", "थ", "थ्", "द्ध", "द", "ध", "ध", "ध्", "ध्", "ध्", "न", "न", "न्",

			"प", "प", "प्", "फ", "फ्", "ब", "ब", "ब्", "भ", "भ्", "म", "म", "म्",
			"य", "य्", "र", "ल", "ल", "ल्", "ळ", "व", "व", "व्",
			"श", "श्", "ष", "ष्", "स", "स", "स्", "ह",

			"ीं", "्र",
			"द्द", "ट्ट", "ट्ठ", "ड्ड", "कृ", "भ", "्य", "ड्ढ", "झ्", "क्र", "त्त्", "श", "श्",

			"ॉ", "ो", "ौ", "ा", "ी", "ु", "ू", "ृ", "े", "ै",
			"ं", "ँ", "ः", "ॅ", "ऽ", "ऽ", "ऽ", "ऽ", "्र", "्", "?", "़", ":",
			"‘", "’", "“", "”", ";", "(", ")", "{", "}", "=", "।", ".", "-", "µ", "॰", ",", "् ", "/"
		);
	}

	public function krutidevToUnicode($modified_substring)
	{
		//$modified_substring='tuin uSuhrky esa jSDoky ls Msydwuk rd eksVj ekxZ dk fuekZ.k ¼f}rh; pj.k½';
		$array_one = $this->krutidevChracter();
		$array_two = $this->unicodeCharacter();
		$array_one_length = count($array_one);
		//substitute array_two elements in place of corresponding array_one elements

		if ($modified_substring != "") // if stringto be converted is non-blank then no need of any processing.
		{
			for ($input_symbol_idx = 0; $input_symbol_idx < $array_one_length; $input_symbol_idx++) {

				$modified_substring = str_replace($array_one[$input_symbol_idx], $array_two[$input_symbol_idx], $modified_substring);
			} // end of for loop****************

			$modified_substring = str_replace('/±/g', '"Zं"', $modified_substring); // at some places  ì  is  used eg  in "कर्कंधु,पूर्णांक".
			$modified_substring = str_replace('/Æ/g', '"र्f"', $modified_substring); // at some places  Æ  is  used eg  in "धार्मिक".
			//echo '</br>position_of_i=';

			//$position_of_i = strpos($modified_substring, "f"); // search for i
			$Uposition_of_i = mb_strpos($modified_substring, "f", 0, 'UTF-8'); // search for i
			while ($Uposition_of_i != false) //while-02
			{
				//echo '</br>charecter_next_to_i=';
				//$charecter_next_to_i = substr($modified_substring, ($position_of_i + 1), 3);
				$charecter_next_to_i = mb_substr($modified_substring, $Uposition_of_i + 1, 1, 'UTF-8');

				//modified_substring.charAt( position_of_i + 1 )
				$charecter_to_be_replaced = "f" . $charecter_next_to_i;
				$modified_substring = str_replace($charecter_to_be_replaced, $charecter_next_to_i . 'ि', $modified_substring);
				//$position_of_i = strpos($modified_substring, "f");
				$Uposition_of_i = mb_strpos($modified_substring, "f", 0, 'UTF-8'); // search for i ahead of the current position.

			} // end of while-02 loop

			//**********************************************************************************
			// Glyph3 & Glyph4: Ç  É
			// code for replacing "fa" with "िं"  and correcting its position too.(moving it two positions forward)
			//**********************************************************************************
			$modified_substring = str_replace('/Ç/g', "fa", $modified_substring); // at some places  Ç  is  used eg  in "किंकर".
			$modified_substring = str_replace('/É/g', "र्fa", $modified_substring); // at some places  É  is  used eg  in "शर्मिंदा"

			$Uposition_of_i = mb_strpos($modified_substring, "fa", 0, 'UTF-8'); // search for i

			while ($Uposition_of_i != false) //while-02
			{
				$charecter_next_to_ip2 = mb_substr($modified_substring, $Uposition_of_i + 1, 1, 'UTF-8');

				$charecter_to_be_replaced = "fa" . $charecter_next_to_ip2;
				$modified_substring = str_replace($charecter_to_be_replaced, $charecter_next_to_ip2 . "िं", $modified_substring);
				$Uposition_of_i = mb_strpos($modified_substring, "fa", 0, 'UTF-8'); // search for i
			} // end of while-02 loop

			//**********************************************************************************
			// Glyph5: Ê
			// code for replacing "h" with "ी"  and correcting its position too.(moving it one positions forward)
			//**********************************************************************************
			$modified_substring = str_replace('/Ê/g', "ीZ", $modified_substring); // at some places  Ê  is  used eg  in "किंकर".

			// following loop to eliminate 'chhotee ee kee maatraa' on half-letters as a result of above transformation.

			$position_of_wrong_ee = mb_strpos($modified_substring, "ि्", 0, 'UTF-8'); // search for i
			//echo 'while start=</br>';
			while ($position_of_wrong_ee != false) //while-03
			{
				//echo 'consonent_next_to_wrong_ee=';
				$consonent_next_to_wrong_ee = mb_substr($modified_substring, $position_of_wrong_ee + 2, 1, 'UTF-8');

				$charecter_to_be_replaced = "ि्" . $consonent_next_to_wrong_ee;
				$modified_substring = str_replace($charecter_to_be_replaced, "्" . $consonent_next_to_wrong_ee . "ि", $modified_substring);
				//echo '<br>';
				$position_of_wrong_ee = mb_strpos($modified_substring, "/ि्/", $position_of_wrong_ee + 2, 'UTF-8'); // search for i
			} // end of while-03 loop
			//echo 'while closed=</br>';


			//**************************************
			//   alert(modified_substring);
			//**************************************

			// Eliminating reph "Z" and putting 'half - r' at proper position for this.
			$set_of_matras = "अ आ इ ई उ ऊ ए ऐ ओ औ ा ि ी ु ू ृ े ै ो ौ ं : ँ ॅ";

			$position_of_R = mb_strpos($modified_substring, "Z", 0, 'UTF-8'); // search for i

			while ($position_of_R > 0) // while-04
			{

				$probable_position_of_half_r = $position_of_R - 1;
				$charecter_at_probable_position_of_half_r = mb_substr($modified_substring, ($probable_position_of_half_r), 1, 'UTF-8');

				// trying to find non-maatra position left to current O (ie, half -r).
				//preg_match($charecter_at_probable_position_of_half_r ,$set_of_matras,$matches,PREG_OFFSET_CAPTURE)

				while (mb_strpos($set_of_matras, $charecter_at_probable_position_of_half_r, 0, 'UTF-8') != false) // while-05

				{

					$probable_position_of_half_r = $probable_position_of_half_r - 1;
					$charecter_at_probable_position_of_half_r = mb_substr($modified_substring, ($probable_position_of_half_r), 1, 'UTF-8');
				} // end of while-05

				$charecter_to_be_replaced = $charecter_at_probable_position_of_half_r = mb_substr($modified_substring, ($probable_position_of_half_r), ($position_of_R - $probable_position_of_half_r), 'UTF-8');

				$new_replacement_string = "र्" . $charecter_to_be_replaced;

				$charecter_to_be_replaced = $charecter_to_be_replaced . "Z";

				$modified_substring = str_replace($charecter_to_be_replaced, $new_replacement_string, $modified_substring);
				$position_of_R = mb_strpos($modified_substring, "Z", 0, 'UTF-8'); // search for i

			} // end of while-04


		} // end of if string avl

		return $modified_substring;
	}

	public static function getMonthListFromDate(Carbon $start, Carbon $end)
	{
		$start = $start->startOfMonth();
		$end   = $end->startOfMonth();

		do {
			$months[$start->format('d-m-Y')] = NULL;
		} while ($start->addMonth() <= $end);

		return $months;
	}
	public static function getDayListFromDate(Carbon $start, Carbon $end)
	{
		if ($start && $end) {
			$all_dates = array();
			while ($start->lte($end)) {
				$all_dates[$start->format('d-m-Y')] = NULL;
				$start->addDay();
			}
			return $all_dates;
		} else {
			return [];
		}
	}

	public static function currentFyYear($year = false, $month = false)
	{
		if ($year && $month) {
		} else {
			$year = Carbon::now()->year;
			$month = Carbon::now()->month;
		}

		if ($month <= 3) {
			$year = $year - 1;
		}
		return $year;
	}

	public static function currentFyYearStartDate($year = false, $month = false)
	{
		return Self::currentFyYear($year, $month) . '-04-01';
	}


	public static function currentFy($year = false, $month = false)
	{
		$year = Self::currentFyYear($year, $month);
		return $year . '-' . ($year + 1);
	}

	public static function makeClickableLinks($text)
	{
		$url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
		$string = preg_replace($url, '<a href="$0" target="_blank" title="$0"><span class="glyphicon glyphicon-tree-conifer" aria-hidden="true"></span></a>', $text);
		return ($string);
	}

	public static function daysBetweenDate(array $dates, $includeLastDay = true)
	{
		$start = ($dates[0] instanceof Carbon) ? $dates[0] : Carbon::parse($dates[0]);
		$end   = ($dates[1] instanceof Carbon) ? $dates[1] : Carbon::parse($dates[1]);
		$days = $start->diffInDays($end);
		return ($includeLastDay) ? $days + 1 : $days;
	}
	public static function getDateFromString($string)
	{
		$matches = "";
		$pattern = "/(\d{2}\/\d{2}\/\d{4})/";
		preg_match_all($pattern, $string, $matches);
		if (!empty($matches)) {
			if ($matches[0]) {
				$datesArray = array();
				foreach ($matches[0] as &$value) {
					$date_array = explode("/", $value);
					$new_date_string = $date_array[2] . "-" . $date_array[1] . "-" . $date_array[0];
					$newDate = date("Y-m-d", strtotime($new_date_string));
					array_push($datesArray, $newDate);
				};
				return $datesArray;
			}
			return false;
		} else {
			return false;
		}
	}
	public static function findUserIDAsArray($userCommaList)
	{
		if ($userCommaList == '') {
			return false;
		}
		return $str_arr = explode(",", $userCommaList);
	}
	public static function get_string_between($string, $start, $end)
	{
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}


	public static function after($identifier, $inthat)
	{
		if (!is_bool(strpos($inthat, $identifier)))
			return substr($inthat, strpos($inthat, $identifier) + strlen($identifier));
	}

	public static function after_last($identifier, $inthat)
	{
		if (!is_bool(strrevpos($inthat, $identifier)))
			return substr($inthat, strrevpos($inthat, $identifier) + strlen($identifier));
	}

	public static function before($identifier, $inthat)
	{
		return substr($inthat, 0, strpos($inthat, $identifier));
	}

	public static function before_last($identifier, $inthat)
	{
		return substr($inthat, 0, strrevpos($inthat, $identifier));
	}

	public static function between($identifier, $that, $inthat)
	{
		return before($that, after($identifier, $inthat));
	}

	public static function between_last($identifier, $that, $inthat)
	{
		return after_last($identifier, before_last($that, $inthat));
	}
	public static function identifyWhatToDo($message)
	{
		$string = explode(' ', $message);
		$firstpart = strtolower($string[0]);
		$secondpart = trim(str_replace($string[0], '', $message));
		switch ($firstpart) {
			case 'rfi':
				return ['todo' => 1, 'search' => $secondpart];
				break;
			case 'cw':
				return ['todo' => 2, 'search' => $secondpart];
				break;
			case 'sb':
				return ['todo' => 3, 'search' => $secondpart];
				break;
			case 'progress':
				//check if date exist
				$string = explode(' ', $secondpart);
				if (count($string) > 1) {
					//date may exist

					if (self::checkInteger($string[0])) {
						$project = $string[0];
					} else {
						$project = 0;
					}
					/*$datePattern="^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$";*/
					$datePattern = '/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/';

					if (preg_match($datePattern, $string[1])) {
						$date = $string[1];
					} else {
						$date = date("Y-m-d");
					}
				} else {
					//date not exist
					if (self::checkInteger($secondpart)) {
						$project = $secondpart;
					} else {
						$project = 0;
					}
					$date = date("Y-m-d");
				}
				return ['todo' => 4, 'project' => $project, 'date' => $date];
				break;
			default:
				return ['todo' => 0, 'search' => $secondpart];
				break;
		}
	}

	public static function checkInteger($value)
	{
		$pattern = '/^\d+$/';
		if (preg_match($pattern, $value)) {
			if ($value > 0) {
				return true;
			}
		}
		return false;
	}

	public static function makeImage($url = "http://pwduk.in:81/pwd/forest", $filename = "mkb")
	{
		//log::info($url);
		$imagePath = "/var/www/html/pwd/filestore/";
		$filename =  $imagePath . $filename . ".png";
		//$url ="http://google.com";
		Browsershot::url($url)->fullPage()->save($filename);
		return $filename;
	}
	public static function url_check($url)
	{
		$headers = @get_headers($url);
		return is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/', $headers[0]) : false;
	}

	public static function splitCamelCase($input)
	{
		$pattern = "/^[0-9]{1,3}+[W]+[0-9]{1,5}$/";
		/*$replacement = "\1w\3/";
    	preg_replace($pattern, $replacement, $input);
    	Log::info("input after W to w= ".print_r($input,true));*/
		$removeAndArray = preg_split("/and|=/i", $input);

		$Spilltedarray = [];
		foreach ($removeAndArray as $key => $value) {
			if (preg_match($pattern, $value)) {
				//it's work code
				$dataArray = [$value];
			} else {
				$dataArray = preg_split(
					'/(^[^A-Z]+|[A-Z][^A-Z]+)/',
					$value,
					-1, /* no limit for replacement count */
					PREG_SPLIT_NO_EMPTY /*don't return empty elements*/
						| PREG_SPLIT_DELIM_CAPTURE /*don't strip anything from output array*/
				);
			} //splitted the text
			//Log::info("Spilltedarray first itteration = ".print_r($dataArray,true));
			$Spilltedarray = array_merge($Spilltedarray, $dataArray);
		}
		//now go for = and upper to lower	    do not think needed as = and filtered
		$Spilltedarray = collect($Spilltedarray)->map(function ($item) {
			$item = strtolower($item);
			$re = "/[\=]/";
			if (strpos($item, "=")) {
				$item = preg_split($re, $item);
				array_push($item, "=");
				return $item;
			} else {
				return $item;
			}
			//return $matches;
		});
		return $Spilltedarray->flatten();
	}
	public static function isForest($optionArray = '')
	{
		$array = [];
		if ($optionArray) {
			$haystack = array('forest', 'forestcase', 'jungle', 'van', 'forestissue', 'forestissues', 'forestcases');
			if (count(array_intersect($haystack, $optionArray)) > 0) {
				//echo "yes forest";				
				$array['matching'] = [
					'filter_field_id' => '26',
					'field' => '26',
					'tbl' => 'work_details'
				];
				$array['operator'] = "="; //initiate it to =
				//parameter selection
				//if yes or no
				$parameterIsYesNo = true;
				//now check negative word
				if ($parameterIsYesNo) {
					$haystack = array('not', 'no', 'none', '<>', '!', '0');
					if (count(array_intersect($haystack, $optionArray)) > 0) {
						$array['parameter'] = 0;
					} else {
						$array['parameter'] = 1;
					}
				} else {
				}
				//if condition need removal
				$haystack = array('remove');
				if (count(array_intersect($haystack, $optionArray)) > 0) {
					$array['status'] = 0;
				} else {
					$array['status'] = 1;
				}
				$array['redirect'] = [
					'route' => 'homeAll',
					'routevalues' => [],
					'widget_id1_parameter' => 'forestCase'
				];
			} //yes forest exist in option
		} //option is not blank
		return  $array;
	}

	public static function isWorkCode($optionArray = '')
	{
		$array = [];
		if ($optionArray) {
			$haystack = array('work_id', 'workcode', 'work_code', 'code_work', 'id_work', 'workid');
			if (count(array_intersect($haystack, $optionArray)) > 0) {
				//echo "yes workcode";				
				$array['matching'] = [
					'filter_field_id' => '33',
					'field' => '33',
					'tbl' => 'works'
				];
				$array['operator'] = "="; //initiate it to =
				//parameter selection
				$parameterIsYesNo = false;
				//if yes or no
				if ($parameterIsYesNo) {
					//now check negative word
					$haystack = array('not', 'no', 'none', '<>', '!', '0');
					if (count(array_intersect($haystack, $optionArray)) > 0) {
						$array['parameter'] = 0;
					} else {
						$array['parameter'] = 1;
					}
				} else {
					//if parameter is data
					$parameter = [];
					//$pattern = "/^[0-9]{1,3}+[w]+[0-9]{1,5}$/";
					foreach ($optionArray as  $str) {
						/*if(preg_match($pattern, $str)){
							array_push($parameter, strtoupper($str));
						}*/
						if ($str = isStringValidWorkCode($str)) {
							array_push($parameter, strtoupper($str));
						}
					}
					$CountOfParameter = count($parameter);
					$array['parameter'] = implode(",", $parameter);
					//Log::info("parameter = ".print_r($parameter,true));
					if ($CountOfParameter > 1) {
						$array['operator'] = "in";
						$array['redirect'] = [
							'route' => 'detailedWorksReport',
							'routevalues' => [
								'field' => 'worktaken',	'value' => 1
							],
							'widget_id1_parameter' => false
						];
					} else {
						$array['operator'] = "=";
						$array['redirect'] = [
							'route' => 'workdetail',
							'routevalues' => [
								'WORK_code' => $array['parameter']
							],
							'widget_id1_parameter' => false
						];
					}
				}
				//if condition need removal
				$haystack = array('remove');
				if (count(array_intersect($haystack, $optionArray)) > 0) {
					$array['status'] = 0;
				} else {
					$array['status'] = 1;
				}
			} //yes work_code exist in option
		} //option is not blank
		return  $array;
	}
	public static function isWorkName($optionArray = '')
	{
		$array = [];
		if ($optionArray) {
			$haystack = array('work_name', 'workname', 'name_of_work');
			if (count(array_intersect($haystack, $optionArray)) > 0) {
				//echo "yes workcode";				
				$array['matching'] = [
					'filter_field_id' => '39',
					'field' => '39',
					'tbl' => 'works'
				];
				$array['operator'] = "Like"; //initiate it to =
				//parameter selection
				$parameterIsYesNo = false;
				//if yes or no
				if ($parameterIsYesNo) {
					//now check negative word
					$haystack = array('not', 'no', 'none', '<>', '!', '0');
					if (count(array_intersect($haystack, $optionArray)) > 0) {
						$array['parameter'] = 0;
					} else {
						$array['parameter'] = 1;
					}
				} else {
					//if parameter is data
					$parameter = [];
					$pattern = "/^[0-9]{1,3}+[w]+[0-9]{1,5}$/";
					foreach ($optionArray as  $str) {
						//if(preg_match($pattern, $str)){
						array_push($parameter, strtoupper($str));
						//}
					}
					//$CountOfParameter=count($parameter);
					$array['parameter'] = implode(",", $parameter);
					$array['operator'] = "Like";
					$array['redirect'] = [
						'route' => 'detailedWorksReport',
						'routevalues' => [
							'field' => 'worktaken',	'value' => 1
						],
						'widget_id1_parameter' => false
					];
					//Log::info("parameter = ".print_r($parameter,true));
					/*if($CountOfParameter>1){
						$array['operator']="in";
						$array['redirect']=[
							'route'=>'detailedWorksReport',
							'routevalues'=>[
								'field'=>'worktaken',	'value'=>1
							],
							'widget_id1_parameter'=>false
						];
					}else{
						$array['operator']="Like";
						$array['redirect']=[
							'route'=>'workdetail',
							'routevalues'=>[
								'WORK_code'=>$array['parameter']
							],
							'widget_id1_parameter'=>false
						];
					}*/
				}
				//if condition need removal
				$haystack = array('remove');
				if (count(array_intersect($haystack, $optionArray)) > 0) {
					$array['status'] = 0;
				} else {
					$array['status'] = 1;
				}
			} //yes work_code exist in option
		} //option is not blank
		return  $array;
	}
	public static function isReset($optionArray = '')
	{
		$array = [];
		if ($optionArray) {
			$haystack = array('reset', 'reset_filter', 'reset_filters');
			if (count(array_intersect($haystack, $optionArray)) > 0) {
				//echo "yes reset filter of user";
				$array['matching'] = [
					//'filter_field_id' => '33',
					//'field' =>'33',
					//'tbl'=>'works'
				];
				$array['status'] = 0;
				$array['redirect'] = [
					'route' => 'homeAll',
					'routevalues' => [],
					'widget_id1_parameter' => ''
				];
			}
		}
		return  $array;
	}
	public static function isAnyStringMatches($serachedString = '', $arrayOfString = [])
	{
		$arrayOfString = implode('|', $arrayOfString);
		if (!preg_match("/$arrayOfString/i", $serachedString)) {
			return false;
		}
		return true;
	}
	public static function isStringValidWorkCode($string = '')
	{
		$result = false;
		if ($string) {
			$pattern = "/^[0-9]{1,3}+[w]+[0-9]{1,5}$/i";
			if (preg_match($pattern, $string)) {
				return strtoupper($string);
			}
		}
		return $result;
	}
	/**
	 * [grpCollection description]
	 * @param  [collection] $collection         [description]
	 * @param  [string] $grpField           [description]
	 * @param  string $grpFieldDateFormat [description]
	 * @return group the  work data as per field and format
	 */
	public static function grpCollection($collection, $grpField, $grpFieldDateFormat = '')
	{
		switch ($grpFieldDateFormat) {
			case 'Y':
			case 'Y-m':
			case 'm-Y':
			case 'M':
			case 'm':
				// date field ,yearwise or monthwise group
				$workgrouped = $collection->groupBy(function ($item) use ($grpFieldDateFormat, $grpField) {
					if ($item->$grpField) {
						//ensure date field contains date not null
						return Carbon::createFromFormat('Y-m-d h:i:s', $item->$grpField)->format($grpFieldDateFormat);
					}
				});
				break;
			case 'numeric':
				// percentage
				// numeric field  start ,end  limit and suffix
				$numericRangeParam = config('site.numeric.' . $grpField);
				// todo intervel should be user defined
				$intv = config('site.' . $grpField . 'interval');
				$workgrouped = $collection->groupBy(function ($item) use ($intv, $numericRangeParam, $grpField) {
					$ll = $numericRangeParam['ll'];
					$ul = $numericRangeParam['ul'];
					$no = ceil(($ul - $ll) / $intv);
					if ($item->$grpField) {
						//ensure field contains data not null
						for ($i = 0; $i < $no; $i++) {
							$ll1 = $ll + $i * $intv;
							$ul1 = $ll1 + $intv - 1;
							if ($item->$grpField >= $ll1 && $item->$grpField <= $ul1) {
								return $ll1 . ' ' . $numericRangeParam['suffix'] . ' to ' . $ul1 . $numericRangeParam['suffix'];
								break;
							}
						}
					}
				});
				break;

			default:
				//normal fields
				$workgrouped = $collection->groupBy($grpField);
				break;
		}

		return $workgrouped;
	}

	/**
	 * [addRemoveValueToCSVField description]
	 * @param [type] $modelCollection    [description]
	 * @param string $csvField           [description]
	 * @param [type] $valueToaddOrRemove [description]
	 * @param [type] $attach  true means add and false means remove
	 */

	public static function addRemoveValueToCSVField($modelCollection, $valueToaddOrRemove, $attach,$csvField = 'users_for_notification')
	{
		foreach ($modelCollection as  $model) {
			$csvFieldItems = $model->$csvField;
			//Log::info("initial with WORK_code = ".$model->WORK_code.print_r($model->users_for_notification,true));
			if ($csvFieldItems) { //already user found
				$userArray = explode(',', $csvFieldItems);
				//Log::info("userArray = ".print_r($userArray,true));
				$pos = array_search($valueToaddOrRemove, $userArray);
				//Log::info("pos = ".print_r($pos,true));
				if ($pos !== FALSE) { //particular user found
					//remove if deattachment required
					//Log::info("pos = ".print_r($pos,true));
					if (!$attach) {
						//Log::info("deattachment required ");
						unset($userArray[$pos]);
						$model->$csvField = implode(',', $userArray);
					}
				} else {
					if ($attach) {
						$model->$csvField = $csvFieldItems . "," . $valueToaddOrRemove;
					}
				}
			} else { //already user not found
				if ($attach) { //only add when attachment required
					$model->$csvField = $valueToaddOrRemove;
				}
			}
			//Log::info("final = ".print_r($model->users_for_notification,true));
			$model->save();
		}
	}
	public static function checkContractorNameAndPan($str = '')
	{
		$result = ['status' => false, 'string' => 'Not provided in proper format (example M/S Xyz:ABCDE1234A)'];
		$regex = "(:)";
		$array = preg_split($regex, $str);
		$count = count($array);
		if ($count == 2) {
			$name = $array[0];
			$pan = $array[1];
			$panregex = '/^([A-Z]{5}[0-9]{4}[A-Z]{1})$/';
			$nameregex = '/^([A-Za-z\/ .,-]+)$/m';
			$pan = str_replace(" ", "", $pan);
			if (!preg_match($panregex, $pan)) {
				$result['string'] = "Pan Card No is not in desired order";
				return $result;
			} else {
				if (!preg_match($nameregex, $name)) {
					$result['string'] = "Name is not in desired order";
					return $result;
				}
			}
			return ['status' => true, 'string' => ['name' => $name, 'pan' => $pan]];;
		}
		return $result;
	}

	/**
	 * CHECK FOR BACK DATE ENTRY.
	 * INPUT TO AND FROM DATE
	 * $for MEANS PHYSICALPROGRESS, FINANCIAL PROGRESS OR ANYTHING ELSE.
	 * VALUES ARE SET IN ---- site.php ----
	 * IF USER DID NOT PASS FROM DATE THEN IT IS TODAY.
	 * RETURN TRUE OR FALSE.
	 * 
	 * BY DEFAULT IT IS IN HOURS.
	 */

	public static function checkBackDate($to, $from, $for)
	{
		//Log::info("checkBackDate entered =$to ");
		if (!$to) {
			return false;
		}
		$to = Carbon::parse($to);

		$from = ($from) ? $from : Carbon::today();

		$setting = config('site.backdate.' . $for);
		//Log::info("to = ".print_r($to,true));

		switch ($setting['calculate_in']) {
			case 1:
				$diff = $to->diffInHours($from);
				break;
			case 2:
				$diff = $to->diffInDays($from);
				break;
			case 3:
				$diff = $to->diffInMonths($from);
				break;
			default:
				$diff = $to->diffInHours($from);
				break;
		}

		return ($diff > $setting['allowedno']) ? false : true;
	}


	public static function checkWorkFieldEditable($to, $fieldname)
	{
		if (Auth::user()->inRole('SuperAdmin')) {
			return true;
		}
		if (!$to) {
			return false;
		}


		$from = Carbon::today();
		$setting = config('site.workDetails.fields.' . $fieldname);
		$calculateIn = ($setting['calculate_in']) ? $setting['calculate_in'] : config('site.workDetails.default.calculate_in');
		$allowedNo = ($setting['allowedno']) ? $setting['allowedno'] : config('site.workDetails.default.allowedno');

		switch ($calculateIn) {
			case 1:
				$diff = $to->diffInHours($from);
				break;
			case 2:
				$diff = $to->diffInDays($from);
				break;
			case 3:
				$diff = $to->diffInMonths($from);
				break;
			default:
				$diff = $to->diffInHours($from);
				break;
		}
		return ($diff <= $allowedNo) ? true : false;
	}

	/**
	 * @param $camelStr text
	 * @return text
	 */
	public static function camelToTitle($camelStr)
	{
		$intermediate = preg_replace('/(?!^)([[:upper:]][[:lower:]]+)/', ' $0', $camelStr);
		$titleStr     = preg_replace('/(?!^)([[:lower:]])([[:upper:]])/', '$1 $2', $intermediate);
		return $titleStr;
	}

	public static function daysToMonth($days)
	{
		if ($days) {
			list($month, $day) = Self::getQuotientAndRemainder($days, 30);
			if ($month && $day) {
				return "$month months , $day days";
			}
			if ($month) {
				return "$month months";
			}
			if ($day) {
				return "$day days";
			}
		}
		return 'None';
	}

	public static function getQuotientAndRemainder($divisor, $dividend)
	{
		$quotient = (int)($divisor / $dividend);
		$remainder = $divisor % $dividend;
		return array($quotient, $remainder);
	}

	public static function xmlTOarray($xmlString)
	{
		$xmlObject = simplexml_load_string($xmlString);
		$json = json_encode($xmlObject);
		return $phpArray = json_decode($json, true);
	}

	public static function formXmlArrayToXml($submissionDetailXmlAsArray)
	{
		$version = $submissionDetailXmlAsArray['@attributes']['version'];
		$replaceString = config('site.form9ModifiedHeader');
		$findString = config('site.form9OrignalHeader');
		$replaceString = str_replace('20210417', $version, $replaceString);
		$findString = str_replace('20210417', $version, $findString);

		//Log::info("submissionDetailXmlAsArray = ".print_r($submissionDetailXmlAsArray,true));
		$xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
		self::arrayToXml($submissionDetailXmlAsArray, $xml_data);
		$result = $xml_data->asXML();
		//Log::info("result------------------- = ".print_r($result,true));
		$result = str_replace($replaceString, $findString, $result);
		//Log::info("result+ changed++++++++++++++++++++++ = ".print_r($result,true));
		return $result;
	}

	public static function arrayToXml($data, &$xml_data)
	{
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				if (is_numeric($key)) {
					$key = 'item' . $key; //dealing with <0/>..<n/> issues
				}
				$subnode = $xml_data->addChild($key);
				self::arrayToXml($value, $subnode);
			} else {
				$xml_data->addChild("$key", htmlspecialchars("$value"));
			}
		}
	}

	public static function check_date_in_range($startDate, $endDate, $dateToCheck)
	{
		return ($dateToCheck->between($startDate, $endDate, true)) ? true : false;
	}


	public static function dateDifference($date_1, $date_2, $differenceFormat = '%a')
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);

		$interval = date_diff($datetime1, $datetime2);
		if (!$differenceFormat) {
			return $interval;
		}

		return $interval->format($differenceFormat);
	}

	public static function getRefinedDayMonthYearFromDays($d)
	{
		$totalDays = $d;
		$years_decimal = ($d / 365); // days / 365 days
		$years = floor($years_decimal); // Remove all decimals

		$totalDays = $years_decimal - $years;

		$months_decimal = ($totalDays * 12);
		$months = floor($months_decimal); // Remove all decimals

		$totalDays = $months_decimal - $months;

		$days = round($totalDays * 30.5, 0);
		return ['d' => $days, 'm' => $months, 'y' => $years];
	}

	public static function getRefinedDayMonthYear($d, $m, $y)
	{
		if ($d > 30) {
			$years = ($d / 365); // days / 365 days
			$years = floor($years); // Remove all decimals
			$months = ($d % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
			$months = floor($months); // Remove all decimals
			$days = fmod(($d % 365), 30.5); // the rest of days
		} else {
			$days = $d;
			$years = 0;
			$months = 0;
		}
		//Log::info("this = ".print_r([$d,$m,$y],true));
		$d = $days;
		$m = $m + $months;
		$y = $y + $years;
		//Log::info("this = ".print_r([$d,$m,$y],true));
		if ($m > 11) {
			$years = ($m / 12);
			$years = floor($years); // Remove all decimals
			$months = $m % 12; // the rest of month
		} else {
			$months = $m;
			$years = 0;
		}
		//Log::info("this = ".print_r([$d,$m,$y],true));

		$m = $months;
		$y = $y + $years;
		return ['d' => $d, 'm' => $m, 'y' => $y];
	}

    public static function lastDateForTransferCOnsideration()
    {
        return Carbon::createFromDate(date('Y'), 5)->endOfMonth()->startOfDay();
    }


	
}

/*call from tinker
$cr = app()->make('App\Http\Controllers\DbUpdation\MakeDashboard');
app()->call([$cr, 'updateWorkBasicDataWithDetail'], []);
 */

/*$settings = Setting::pluck('value', 'key')->toArray(); 
		 // $settings = ['site.name'=>'fromdbbbbbbbbbb'];
		 config($settings);
		 return $config_items = app('config')->all();*/

		 // style="background-color: {{ config('site.colorSeries4.'.$i) }}"
		 /* public static function splitCamelCase($str) {
			  return preg_split('/(?<=\\w)(?=[A-Z])/', $str);
			}*/
