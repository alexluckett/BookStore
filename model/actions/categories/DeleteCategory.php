<?php

/**
 * Description of DeleteCategory
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteCategory extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        if(!isset($requestParams['catId'])) {
            throw new Exception("Please select a valid category to delete.");
        }
        
        $catId = $requestParams['catId'];
        
        $this->deleteBooksForCategory($catId);
        $this->deleteCategory($catId);
        
        $_REQUEST["categories"] = CategoryDAO::getBookCategories(); // refresh list
    }
    
    private function deleteBooksForCategory($catId) {
        $booksForCat = BookDAO::getBooksForCategory($catId);
        
        foreach($booksForCat as $book) {
            $this->deleteBook($book->isbn);
        }
    }
    
    private function deleteBook($isbn) {
        $bookDeleter = new DeleteBook($this->minimumPermissionLevel);
        
        $bookArray = array(
            "isbn" => $isbn
        ); // execution is expecing an array of parameters
        
        $bookDeleter->execute($bookArray);
    }
    
    private function deleteCategory($catId) {
        CategoryDAO::deleteCategory($catId);
    }

    public function pageInclude() {
        return "/view/staff/viewCategories.php";
    }

}