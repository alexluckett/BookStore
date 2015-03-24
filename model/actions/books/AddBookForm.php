<?php

/**
 * Displays the page to add a book.
 */
class AddBookForm extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }
    
    public function execute($requestParams) {
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
    }

    public function pageInclude() {
        return "/view/staff/addBookForm.php";
    }

}