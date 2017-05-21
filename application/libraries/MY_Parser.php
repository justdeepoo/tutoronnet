<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Sparser Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Parser
 * @author        Jonathon Hill
 * @link        jhill@goyoders.com
 */
class MY_Parser extends CI_Parser {

    /**
     *  Parse a string
     *
     * Parses pseudo-variables contained in the specified string,
     * replacing them with the data in the second param
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    bool
     * @return    string
     */
    function sparse($template, $data, $return = FALSE)
    {
        $CI =& get_instance();
        
        if ($template == '')
        {
            return FALSE;
        }
        foreach ($data as $key => $val)
        {
            if (is_array($val))
            {
                $template = $this->_parse_pair($key, $val, $template);        
            }
            else
            {
                $template = $this->_parse_single($key, (string)$val, $template);
            }
        }
        
        if ($return == FALSE)
        {
            $CI->output->final_output = $template;
        }
        
        return $template;
    }
    
}
// END Sparser Class
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>