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
    
    public static function getBook($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.*, bookCategories.categoryName 
            FROM books, bookCategories, bookCategoryAssociation
            WHERE bookCategoryAssociation.isbn = books.isbn
            AND bookCategories.categoryId = bookCategoryAssociation.categoryId
            AND books.isbn = $isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $book = $statement->fetch();
        
        return $book; // need one user returned, else invalid login details
    }
    
    public static function getBooksFromDatabase() {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.*, bookCategories.categoryName 
            FROM books, bookCategories, bookCategoryAssociation
            WHERE bookCategoryAssociation.isbn = books.isbn
            AND bookCategories.categoryId = bookCategoryAssociation.categoryId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books; // need one user returned, else invalid login details
    }
    
    public static function getBooksForCategory($categoryId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.* FROM books WHERE books.isbn IN
                    (SELECT isbn FROM bookCategoryAssociation WHERE categoryId = $categoryId)";

        $statement = $db->prepare($query);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books; // list of all books for that category
    }
    
    public static function getBookCategories() {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT * FROM bookCategories";

        $statement = $db->prepare($query);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookCategoryModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books; // list of all categories
    }
    
    public static function increaseQuantity($isbn, $quantityToAdd) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE books SET quantity = quantity + $quantityToAdd WHERE isbn = $isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        return $statement->execute();
    }
    
    public static function decrementQuantity($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE books SET quantity = quantity - 1 WHERE isbn = $isbn and quantity > 0";

        $statement = $db->prepare($query); // protect against SQL injection
        return $statement->execute();
    }
    
}
