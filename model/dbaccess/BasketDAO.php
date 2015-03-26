<?php

/**
 * Abstraction layer for database communication relating to user's basket.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BasketDAO {
    
    public static function addToBasket($userId, $isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "INSERT into userBasket VALUES(:userId, :isbn)";
        
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":isbn", $isbn);
        
        return $statement->execute();
    }
    
    public static function getBooksFromBasket($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.* from books, userBasket "
                . "WHERE userBasket.userId = :userId AND books.isbn = userBasket.isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        
        $bookList = $statement->fetchAll();
        
        return $bookList; 
    }
    
    /**
     * Removes a book from a user's basket.
     * 
     * @param int $userId
     * @param string $isbn
     * @return boolean
     */
    public static function removeFromBasket($userId, $isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "DELETE FROM userBasket WHERE userId = :userId AND isbn = :isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":isbn", $isbn);
        
        return $statement->execute();
    }
    
    public static function emptyBasket($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "DELETE FROM userBasket WHERE userId = :userId";

        $statement = $db->prepare($query);
        $statement->bindValue(":userId", $userId);
        
        return $statement->execute();
    }
}
