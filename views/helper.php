<?php
/**
 * Helper Functions - Modernized with backward compatibility
 * New code should use Shuurkhai\Core\Helpers class directly
 */

// Autoload modern classes via Composer
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once($composerAutoload);
} else {
    // Fallback: manual require if composer not installed
    require_once(__DIR__ . '/../lib/Database.php');
    require_once(__DIR__ . '/../lib/Helpers.php');
}

use Shuurkhai\Core\Helpers;

// Backward compatibility wrapper functions
if (! function_exists ('string_clean'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::stringClean() instead
	 */
	function string_clean($string)
	{
		return Helpers::stringClean($string);
	}
}



if (! function_exists ('customer'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::customer() instead
	 */
	function customer($customer_id, $parameter)
	{
		return Helpers::customer((int)$customer_id, (string)$parameter) ?? '';
	}
}


if (! function_exists ('tracksearch'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::trackSearch() instead
	 */
	function tracksearch($track)
	{
		return Helpers::trackSearch((string)$track);
	}
}

if (! function_exists ('tracksearch_container'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::trackSearchContainer() instead
	 */
	function tracksearch_container($track)
	{
		return Helpers::trackSearchContainer((string)$track);
	}
}


if (!function_exists("protect"))
{
	/**
	 * Protect function - хуучин функц (backward compatibility)
	 * Шинэ код дээр sanitize_input() ашиглах зөвлөмжлөгдөнө
	 */
	function protect($input)
	{
		// Хуучин функц хадгалж байна (backward compatibility)
		// Гэхдээ илүү сайн sanitization хийх
		if (is_array($input)) {
			return array_map('protect', $input);
		}
		
		// HTML tags устгах
		$input = strip_tags($input);
		
		// SQL injection-ээс хамгаалах (гэхдээ prepared statements ашиглах нь илүү сайн)
		$input = str_replace("'", "", $input);
		$input = str_replace('"', '', $input);
		$input = str_replace(";", "", $input);
		$input = str_replace("--", "", $input);
		
		// XSS-ээс хамгаалах
		$input = str_replace("<", "", $input);
		$input = str_replace(">", "", $input);
		$input = str_replace("script", "", $input);
		
		return trim($input);
	}
}


if (!function_exists("settings"))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::settings() instead
	 */
	function settings($id_or_shortname)
	{
		if (is_int($id_or_shortname)) {
			return Helpers::settings($id_or_shortname);
		}
		return Helpers::settings((string)$id_or_shortname);
	}
}


if (!function_exists('mslog'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::msLog() instead
	 */
	function mslog($name, $request, $response, $method)
	{
		Helpers::msLog((string)$name, (string)$request, (string)$response, (string)$method);
	}
}


if (! function_exists ('cfg_price'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::cfgPrice() instead
	 */
	function cfg_price($weight)
	{
		return Helpers::cfgPrice((float)$weight);
	}
}

// Fix image paths for base href
if (!function_exists('fix_image_path'))
{
	/**
	 * @deprecated Use Shuurkhai\Core\Helpers::fixImagePath() instead
	 */
	function fix_image_path($path)
	{
		return Helpers::fixImagePath((string)$path);
	}
}


?>
