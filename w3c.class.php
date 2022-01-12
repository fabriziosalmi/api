<?php
// require_once("conf/sentry.php");

/**
 * W3cValidate
 * 
 * For more information on this file and how to use the class please visit
 * http://www.hashbangcode.com/blog/w3c-validation-php-class-1300.html
 *
 * @author       Philip Norton
 * @version   1.0
 * @copyright 2009 #! code
 * 
 */
 
/**
 * This class allows the retreival of W3C HTML validation results.
 *
 * @package    W3cValidate
 */
class W3cValidate{
    
    /**
     * The URL used in the test
     *
     * @var string
     */
    private $url;
 
    /**
     * The W3C validation results for tested URL
     *
     * @var integer
     */
    public $result;
    
    /**
     * Constructor 
     *
     * @param string $url The URL that will be used in the test.
     */
    public function W3cValidate($url){
        print_r(" ". $url ." ");
        $url = urlencode($url);
        // Make sure the URL has http in front of it
        $this->url = $url;
    }
    
    /**
     * Get the results from the W3C validation site and use regular expressions to return a result. 
     *
     * @return integer The number of errors, or -1 if an error was encountered.
     */
    public function getValidation(){    
        $w3cvalidator = strip_tags(file_get_contents("https://validator.w3.org/check?uri=".$this->url));
        // Validator response is null
        if ( $w3cvalidator == '' ) {
            $this->result = -1;
            return $this->result;
        }
        // Validator responded, check results
        preg_match_all('/(?<=Result:)\s+(\d)*(?= errors?)/i', $w3cvalidator, $matches);
        if ( isset($matches[0][0]) ) {
            $this->result = trim($matches[0][0]);
            return $this->result;
        }
        // Check for broken document
        preg_match_all('/Sorry! This document can not be checked\./i', $w3cvalidator, $matches);
        if ( isset($matches[0][0]) ) {
            $this->result = -1;
            return $this->result;                    
        }
        // Document is valid
        $this->result = 0;
        return $this->result;
    }
}