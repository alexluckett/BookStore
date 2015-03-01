<?php

/**
 * Displays the page for adding a book quantity.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewAddQuantity extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $book;
        
        if(isset($requestParams['isbn'])) {
            $book = BookDAO::getBook($requestParams['isbn']);
        }
        
        $_REQUEST['book'] = $book;
    }

    public function pageInclude() {
        return "/view/staff/viewEditBook.php";
    }

}
