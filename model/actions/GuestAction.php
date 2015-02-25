<?php

/**
 * Description of GuestAction
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class GuestAction implements IAction {
    
    public abstract function execute();
    public abstract function pageInclude();
    
    public function isLegalRequest() {
        return true; // guest actions are always legal
    }
}
