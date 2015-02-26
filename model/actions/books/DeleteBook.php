<?php

/**
 * Description of DeleteBook
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteBook extends AuthenticatedAction {
    
    public function execute($requestParams) {        
        $isbn = "";
        
        if(isset($requestParams['isbn'])) {
            $isbn = $requestParams['isbn'];
        }
        
        $success = $this->deleteBookFromDatabase($isbn);
        
        if($success) {
            $_REQUEST['message'] = 'Book: '.$isbn.' deleted';
        } else {
            $_REQUEST['message'] = 'Unable to delete book.';
        }
        
        $_REQUEST["books"] = BookView::getBooksFromDatabase();
    }

    public function pageInclude() {
        return "/view/student/bookList.php";
    }
    
    private function deleteBookFromDatabase($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "DELETE from books WHERE books.isbn = '".$isbn."'";
        $query2 = "DELETE from userBasket WHERE isbn = '".$isbn."'";
        
        $statement = $db->prepare($query); // protect against SQL injection
        $statement2 = $db->prepare($query2);
        
        $success = $statement->execute();
        $success2 = $statement2->execute();
        
        return $success && $success2;
    }
    
}
