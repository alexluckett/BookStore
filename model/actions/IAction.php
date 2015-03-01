<?php

/**
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
interface IAction {
    
    /**
     * Responsible for action execution, called before page output.
     * Should initialise output variables for the view to utilise.
     */
    function execute($requestParams);
    
    /**
     * Returns a string representing the file to include after execution.
     * Should be relative to path of index.php.
     */
    function pageInclude();
    
    /**
     * Used to confirm if user can execute this action. Action will be executed
     * depending on true/false return value.
     * 
     * @return boolean
     */
    function isLegalRequest();
    
}
