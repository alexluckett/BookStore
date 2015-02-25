<?php

/**
 * Description of DisplayError
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DisplayError extends GuestAction {
    
    public function execute() { }

    public function pageInclude() {
        return "/view/displayError.php";
    }

}
