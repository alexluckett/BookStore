<?php

/**
 * Displays the page to add a book.
 */
class AddBookForm extends AuthenticatedAction {
    
    public function execute($requestParams) { } // nothing to do here

    public function pageInclude() {
        return "/view/staff/addBookForm.php";
    }

}