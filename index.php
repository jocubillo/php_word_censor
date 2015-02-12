<?php 
	
	$str = "who the fuck are you? you fucking shit!";
	$censored = array("fuck","shit");

	echo word_censor($str,$censored,"***");

	function word_censor($str, $censored, $replacement = '')
		{
			if ( ! is_array($censored))
			{
				return $str;
			}

			$str = ' '.$str.' ';

			// \w, \b and a few others do not match on a unicode character
			// set for performance reasons. As a result words like über
			// will not match on a word boundary. Instead, we'll assume that
			// a bad word will be bookeneded by any of these characters.
			$delim = '[-_\'\"`(){}<>\[\]|!?@#%&,.:;^~*+=\/ 0-9\n\r\t]';

			foreach ($censored as $badword)
			{
				if ($replacement != '')
				{
					$str = preg_replace("/({$delim})(".str_replace('\*', '\w*?', preg_quote($badword, '/')).")({$delim})/i", "\\1{$replacement}\\3", $str);
				}
				else
				{
					$str = preg_replace("/({$delim})(".str_replace('\*', '\w*?', preg_quote($badword, '/')).")({$delim})/ie", "'\\1'.str_repeat('#', strlen('\\2')).'\\3'", $str);
				}
			}

			return trim($str);
		}

?>