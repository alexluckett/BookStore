<?php

include_once 'model/BookModel.php';

/**
 * Description of BookView
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookView extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $books = BookDAO::getBooksFromDatabase();
        
        $_REQUEST["books"] = $books;
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/student/bookList.php";
    }

}
