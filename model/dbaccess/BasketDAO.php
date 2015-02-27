<?php

/**
 * Description of BasketDAO
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BasketDAO {
    
    public static function addToBasketInDatabase($userId, $isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "INSERT into userBasket VALUES(".$userId.",".$isbn.")";
        $statement = $db->prepare($query); // protect against SQL injection
        
        return $statement->execute();
    }
   
    public static function getBooksFromBasket($userId) {
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
