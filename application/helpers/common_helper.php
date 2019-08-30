<?php
/**
 * @param string $string
 * @return string
 */
function public_helper($string = '')
{
    return base_url('public/' . $string);
}

/**
 * @param $word
 * @return array
 */
function getLevenshtein($word)
{
    $words = array();
    for ($i = 0; $i < strlen($word); $i++) {
        // insertions
        $words[] = substr($word, 0, $i) . '_' . substr($word, $i);
        // deletions
        $words[] = substr($word, 0, $i) . substr($word, $i + 1);
        // substitutions
        $words[] = substr($word, 0, $i) . '_' . substr($word, $i + 1);
    }
    // last insertion
    $words[] = $word . '_';
    return $words;
}

/**
 * @param $data
 * @param $time
 * @return array
 */
function get_weather_by_time($data, $time)
{
    $result = array();
    foreach ($data as $line){
        $line_arr = explode(',',$line);
        $datetime = (isset($line_arr[1])) ? $line_arr[1] : '';
        $hour = date('H',strtotime($datetime));
        $hour = $hour.":00";
        if($time == $hour){
            $result[] = $line;
        }
    }
    return $result;
}

/**
 * @param $password
 * @return string
 */
function bScript($password){
    $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
    return crypt($password, $salt);
}

/**
 * @param $password
 * @param $hashedPassword
 * @return bool
 */
function verify_password($password, $hashedPassword) {
    return (crypt($password, $hashedPassword) == $hashedPassword);
}