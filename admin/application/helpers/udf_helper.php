<?php


if(!function_exists('print_OctHeaderFooterCSSJS')){
    function print_OctHeaderFooterCSSJS($type='')
    {
        $str = '';
        $ci = &get_instance();
        $elementsToPrint  = $ci->config->item($type);
       	if (strpos($type, '_js'))
		{
    		foreach($elementsToPrint AS $item){
	        	if ($item['type'] == 'inline')
				{
					 $str .=   $item['script'] . "\n";
				} else {
					
					$str .= '<script type="text/javascript" src="' .$item['script'] . '"></script>'."\n";
				}
			}
		} else {
			foreach($elementsToPrint AS $item){
				if ($item['type'] == 'inline')
				{
					 $str .=   $item['style'] . "\n";
				} else {
					
					$str .= '<link type="text/css" rel="stylesheet" href="' .$item['style'] . '"/>'."\n";
				}
			}
		}
        return $str;
    }
}
if(!function_exists('add_header_footer_cssJS')){
    function add_header_footer_cssJS($addToElement='',$add=Array())
    {
        $ci = &get_instance();
        $currentConfig = $ci->config->item($addToElement);
        array_push($currentConfig, $add);
        $ci->config->set_item($addToElement, $currentConfig);
    }
}
if(!function_exists('octSearchForId')){
	function octSearchForId($id, $array) {
	   foreach ($array as $key => $val) {
	       if ($val['uid'] === $id) {
	           return $key;
	       }
	   }
	   return null;
	}
}
?>