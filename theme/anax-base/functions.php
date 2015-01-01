<?php
/**
 * Theme related functions. 
 *
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @param string $titleAppend a general title to append.
 * @return string/null wether the favicon is defined or not.
 */
/*function get_title($title, $titleAppend = null) {
  return $title . $title_append;
}
*/

function today(){

	$day = date("l");
    $day2 = date("d");
    $month = date("m");
    $year = date("Y");
                    
    $html = "<div id='date'>Dagens datum: " . $year ."-" .$month ."-" .$day2;
	$html .= "</div>";
	
	return $html;


}

/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CLydia::Instance()->user['email']))) . '.jpg?' . ($size ? "s=$size" : null);
}




