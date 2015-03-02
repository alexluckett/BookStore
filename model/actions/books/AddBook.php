<?php

include_once 'model/utils/FileUploader.php';

/**
 * Adds a book into the system.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddBook extends AuthenticatedAction {
    
    public function execute($requestParams) { 
        $bookModel = $this->constructBook($requestParams);
        $categoryId = $requestParams['categories'];
        
        $success = BookDAO::addBookToDatabase($bookModel, $categoryId);
        
        $this->uploadFile($bookModel);
        
        if($success) {
            $_REQUEST['message'] = 'Book: '.$bookModel->isbn.' added';
            $_REQUEST['alertType'] = 'success';
        } else {
            $_REQUEST['message'] = 'Unable to add book.';
        }
        
        $_REQUEST['books'] = BookDAO::getBooksFromDatabase();
        $_REQUEST["categories"] = BookDAO::getBookCategories();
    }
    
    private function uploadFile($book) {
        $uploadedFile = $_FILES['uploadedFile'];
        
        $fileType = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $uploadedFile['name'] = $book->isbn.".".$fileType;
        
        $permittedFileTypes = array("png");
        
        $fileUploader = new FileUploader("view/images/bookcovers", $permittedFileTypes);
        $fileUploader->saveFile($uploadedFile);
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }
    
    private function constructBook($requestParams) {
        $book = new BookModel();
        
        foreach ($requestParams as $key => $value) { // use magic setter methods to enter book details
            $book->$key = $value;
        }
        
        return $book;
    }
    
}