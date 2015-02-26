<?php

/**
 * Description of ViewBasket
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBasket extends AuthenticatedAction {
    
    public function execute($requestParams) {
        $userId = $_SESSION['userId'];
        $bookList = $this->getBooksFromBasket($userId);
        
        $_REQUEST['bookList'] = $bookList;
    }

    public function pageInclude() {
        return "/view/student/viewBasket.php";
    }
    
    private function getBooksFromBasket($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.* from books, userBasket "
                . "WHERE userBasket.userId = '$userId' AND books.isbn = userBasket.isbn;";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        
        $bookList = $statement->fetchAll();
        
        return $bookList; 
    }
}
