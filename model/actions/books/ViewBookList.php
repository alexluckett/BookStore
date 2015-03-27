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
        
        $refineByCategory = isset($requestParams['categoryId']); // if user wants specific category
                
        if($refineByCategory) {
            if(isset($requestParams['categoryId']) && $requestParams['categoryId'] != 0) { // advanced search for category
                $books = BookDAO::getBooksForCategory($requestParams['categoryId']); // gets books for a single category, providing category is valid
            } else {
                $books = BookDAO::getBookList(); // all books, regardless of category. category 0 = all.
            }
        } else {
            $books = BookDAO::getBookList(); // all books
        }
        
        $_REQUEST["books"] = $books; // send to view
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }

}
