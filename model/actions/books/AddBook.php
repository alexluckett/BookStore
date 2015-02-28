<?php

/**
 * Description of AddBook
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddBook extends AuthenticatedAction {
    
    public function execute($requestParams) {
        $bookModel = $this->constructBook($requestParams);
        
        $success = BookDAO::addBookToDatabase($bookModel);
        
        if($success) {
            $_REQUEST['message'] = 'Book: '.$bookModel->isbn.' added';
            $_REQUEST['alertType'] = 'success';
        } else {
            $_REQUEST['message'] = 'Unable to add book.';
        }
        
        $_REQUEST['books'] = BookDAO::getBooksFromDatabase();
    }

    public function pageInclude() {
        return "/view/student/bookList.php";
    }
    
    private function constructBook($requestParams) {
        $book = new BookModel();
        
        foreach ($requestParams as $key => $value) { // use magic setter methods to enter book details
            $book->$key = $value;
        }
        
        return $book;
    }
    
}
