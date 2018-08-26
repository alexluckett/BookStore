<?php

/**
 * Commonly used string validation functions.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class StringUtils {
    
    public static function isAlphabetical($string) {
        return preg_match("/[a-z]/i", $string);
    }
    
    public static function isNumeric($string) {
        return preg_match("/[0-9]/", $string);
    }
    
    public static function isAlphaumeric($string) {
        return preg_match("/[a-z0-9]/i", $string);
    }
    
    public static function stripSymbols($string) {
        return preg_replace("/[^a-z0-9]/i", "", $string);
    }
    
}
