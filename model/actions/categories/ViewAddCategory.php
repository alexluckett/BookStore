<?php

/**
 * Displays the page for adding a new book category
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewAddCategory extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) { } // nothing to do here, only page include below

    public function pageInclude() {
        return "/view/staff/addCategoryPage.php";
    }

}
