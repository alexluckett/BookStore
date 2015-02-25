<?php

/**
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
interface IAction {
    
    /**
     * Executes the business action run from the controller.
     */
    function execute();
    
    /**
     * Returns a string representing the path of the PHP file to include after execute() is run.
     */
    function pageInclude();
    
    /**
     * Returns true or false, depending on if the request should be allowed or not.
     */
    function isLegalRequest();
}
