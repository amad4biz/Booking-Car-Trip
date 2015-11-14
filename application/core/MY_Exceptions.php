<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * Umer Farooq... Original from Mike... for config... then changed based on.
 * https://ellislab.com/forums/viewthread/230036/#1042190
 * 
 */
class MY_Exceptions extends CI_Exceptions {

     public function __construct()
    {
        parent::__construct(); 
    }

    public  function show_php_error($severity, $message, $filepath, $line)
    {
        $ci =& get_instance();
		
        // this allows different params for different environments
        $ci->config->load('email_php_errors');
		
        // if it's enabled
        if (config_item('email_php_errors'))
        {
			// set up email with config values
			$ci->load->library('email');
			$ci->email->from(config_item('php_error_from'));
			$ci->email->to(config_item('php_error_to'));

			// set up subject
			$subject = config_item('php_error_subject');
			$subject = $this->_replace_short_tags($subject, $severity, $message, $filepath, $line);
			$ci->email->subject($subject);

			// set up content
			$content = config_item('php_error_content');
			$content = $this->_replace_short_tags($content, $severity, $message, $filepath, $line);

			// set message and send
			$ci->email->message($content);
			$ci->email->send();
		}
		$msg = 'Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line;
		
		
        // do the rest of the codeigniter stuff
        parent::show_php_error($severity, $message, $filepath, $line);
    }

    // --------------------------------------------------------------------------

    /**
     * replace short tags with values.
     *
     * @access private
     * @param string $content
     * @param string $severity
     * @param string $message
     * @param string $filepath
     * @param int $line
     * @return string
     */
    private function _replace_short_tags($content, $severity, $message, $filepath, $line)
    {
        $content = str_replace('{{severity}}', $severity, $content);
        $content = str_replace('{{message}}', $message, $content);
        $content = str_replace('{{filepath}}', $filepath, $content);
        $content = str_replace('{{line}}', $line, $content);

        return $content;
    }

    // --------------------------------------------------------------------------
}
/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */