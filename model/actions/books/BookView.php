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
    
    private function displayAllBooks() {
        return BookDAO::getBooksFromDatabase();
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }

}
