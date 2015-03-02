<?php

include_once 'model/BookModel.php';

/**
 * Displays the page for viewing a list of books.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBookList extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $_REQUEST["categories"] = BookDAO::getBookCategories();
        
        $refineByCategory = isset($requestParams['categoryId']);
                
        if($refineByCategory) {
            if(isset($requestParams['categoryId']) && $requestParams['categoryId'] != 0) {
                $books = BookDAO::getBooksForCategory($requestParams['categoryId']);
            } else {
                $books = BookDAO::getBooksFromDatabase();
            }
        } else {
            $books = BookDAO::getBooksFromDatabase();
        }
        
        $_REQUEST["books"] = $books;
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }

}
