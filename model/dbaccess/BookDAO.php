<?php

/**
 * Description of BookDAO
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookDAO {
    
    public static function addBookToDatabase($bookModel) {
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
    
    public static function deleteBookFromDatabase($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "DELETE from books WHERE books.isbn = '".$isbn."'";
        $query2 = "DELETE from userBasket WHERE isbn = '".$isbn."'";
        
        $statement = $db->prepare($query); // protect against SQL injection
        $statement2 = $db->prepare($query2);
        
        $success = $statement->execute();
        $success2 = $statement2->execute();
        
        return $success && $success2;
    }
    
    public static function getBooksFromDatabase() {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT * from books";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books; // need one user returned, else invalid login details
    }
    
}
