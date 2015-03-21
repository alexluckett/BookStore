<?php

/**
 * Deletes a book from the system
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteBook extends AuthenticatedAction {
    
    public function execute($requestParams) {        
        $isbn = "";
        
        if(isset($requestParams['isbn'])) {
            $isbn = $requestParams['isbn'];
        }
        
        $success = BookDAO::deleteBook($isbn);
        
        if($success) {
            $this->deleteCoverImage($isbn);
            $_REQUEST['message'] = 'Book: '.$isbn.' deleted';
        } else {
            $_REQUEST['message'] = 'Unable to delete book.';
        }
        
        $_REQUEST["books"] = BookDAO::getBookList();
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }
    
    private function deleteCoverImage($isbn) {
        $filePath = AddBook::UPLOAD_DIRECTORY."/".$isbn.".png";
        
        if(isset($isbn) && file_exists($filePath)) {
            unlink($filePath);
        }
    }
    
}
