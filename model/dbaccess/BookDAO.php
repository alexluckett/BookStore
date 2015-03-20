<?php

/**
 * Abstraction layer for database communication relating to books.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookDAO {
    
    public static function addBookToDatabase($bookModel, array $categoryIds) {        
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
        
        $success = $statement->execute(); // boolean
        
        self::setBookCategories($bookModel->isbn, $categoryIds);
        
        return $success;
    }
    
    public static function setBookCategories($isbn, array $categoryIds) {
        $db = DatabaseConnection::getDatabase();
        
        foreach($categoryIds as $catId) {
            $query = "INSERT INTO bookCategoryAssociation VALUES ($isbn, $catId)";

            $statement = $db->prepare($query); // protect against SQL injection

            $statement->execute(); // boolean
        }
    }
    
    public static function deleteBookFromDatabase($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query1 = "DELETE from bookCategoryAssociation WHERE isbn = '".$isbn."'";
        $query2 = "DELETE from books WHERE books.isbn = '".$isbn."'";
        $query3 = "DELETE from userBasket WHERE isbn = '".$isbn."'";
        
        
        $statement1 = $db->prepare($query1); // protect against SQL injection
        $statement2 = $db->prepare($query2);
        $statement3 = $db->prepare($query3);
        
        $success1 = $statement1->execute();
        $success2 = $statement2->execute();
        $success3 = $statement3->execute();
        
        return $success1 && $success2 && $success3;
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

        $query = "SELECT * FROM books";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        foreach($books as $book) { // set categories for each book
            $bookCats = self::getCategoriesForBook($book->isbn);
            $book->categories = $bookCats;
        }
        
        return $books; // need one user returned, else invalid login details
    }
    
    public static function getCategoriesForBook($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT DISTINCT bookCategories.* FROM bookCategories, bookCategoryAssociation
                  WHERE bookCategories.categoryId
                  IN (SELECT categoryId FROM bookCategoryAssociation WHERE isbn = '$isbn')";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookCategoryModel');
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
        
        foreach($books as $book) { // set categories for each book
            $bookCats = self::getCategoriesForBook($book->isbn);
            $book->categories = $bookCats;
        }
        
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
