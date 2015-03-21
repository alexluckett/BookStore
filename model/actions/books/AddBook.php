<?php

include_once 'model/utils/FileSaver.php';

/**
 * Adds a book into the system.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddBook extends AuthenticatedAction {
    
    public function execute($requestParams) { 
        $bookModel = $this->constructBook($requestParams);
        $categoryId = $requestParams['categories'];
        
        $success = BookDAO::addBook($bookModel, $categoryId);
        
        if($success) {
            $this->uploadFile($bookModel); // only upload if book was added
            $_REQUEST['message'] = 'Book: '.$bookModel->isbn.' added';
            $_REQUEST['alertType'] = 'success';
        } else {
            $_REQUEST['message'] = 'Unable to add book.';
        }
        
        $_REQUEST['books'] = BookDAO::getBookList();
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
    }
    
    /**
     * Uploads the cover image for a book.
     * 
     * @param type $book
     */
    private function uploadFile($book) {
        $uploadedFile = $_FILES['uploadedFile'];
        
        $fileType = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION); // extract file type from full path
        $uploadedFile['name'] = $book->isbn.".".$fileType; // all file names must be the book's ISBN
        
        $permittedFileTypes = array("png"); // restricted to php for now, but can be extended
        
        try {
            $fileUploader = new FileSaver("view/images/bookcovers", $permittedFileTypes);
            $fileUploader->saveFile($uploadedFile);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage()." Placeholder cover photo will be used."); // apend specialised error message to exception
        }
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }
    
    /**
     * Constructs a book model from the given parameters.
     * @param type $requestParams
     * @return \BookModel
     */
    private function constructBook($requestParams) {
        $book = new BookModel();
        
        foreach ($requestParams as $key => $value) { // use magic setter methods to enter book details    
            $book->$key = $value;
        }
        
        return $book;
    }
    
}