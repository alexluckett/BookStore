<?php

include_once 'model/BookModel.php';

/**
 * Displays the page for viewing a list of books.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBookList extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::userPermission);
    }

    public function execute($requestParams) {
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
        
        $refineByCategory = isset($requestParams['categoryId']);
                
        if($refineByCategory) {
            if(isset($requestParams['categoryId']) && $requestParams['categoryId'] != 0) {
                $books = BookDAO::getBooksForCategory($requestParams['categoryId']);
            } else {
                $books = BookDAO::getBookList();
            }
        } else {
            $books = BookDAO::getBookList();
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
