<?php

/**
 * Description of GuestAction
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class GuestAction implements IAction {
    
    /**
     * Responsible for action execution, called before page output.
     * Should initialise output variables for the view to utilise.
     */
    public abstract function execute($requestParams);
    
    /**
     * Returns a string representing the file to include after execution.
     * Should be relative to path of index.php.
     */
    public abstract function pageInclude();
    
    /**
     * Used to confirm if user can execute this action. GuestActions are 
     * always permitted (user does not need to be logged in), 
     * so this will always return true.
     * 
     * @return boolean
     */
    public function isLegalRequest() {
        return true; // guest actions are always legal
    }
}
