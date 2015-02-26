<?php

/**
 * Description of AddBook
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddBook extends AuthenticatedAction {
    
    public function execute($requestParams) {$bookModel = $this->constructBook($requestParams);
        
        $success = $this->addBookToDatabase($bookModel);
        
        if($success) {
            $_REQUEST['message'] = 'Book: '.$bookModel->isbn.' added';
            $_REQUEST['alertType'] = 'success';
        } else {
            $_REQUEST['message'] = 'Unable to add book.';
        }
        
        $_REQUEST['books'] = BookView::getBooksFromDatabase();
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
    
    private function addBookToDatabase($bookModel) {
        $db = DatabaseConnection::getDatabase();

        $query = "INSERT INTO books VALUES ("; // construct statment, append all values from book model
        {
            $query.= "'".$bookModel->isbn."',";
            $query.= "'".$bookModel->title."',";
            $query.= "'".$bookModel->author."',";
            $query.= $bookModel->price.",";
            $query.= $bookModel->quantity;
        }
        $query.= ")";

        $statement = $db->prepare($query); // protect against SQL injection
        
        return $statement->execute(); // boolean
    }

//put your code here
}
