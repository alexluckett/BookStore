<?php

/**
 * Abstraction layer for database communication relating to books.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookDAO {
    
    /**
     * Adds a book into the database/
     * 
     * @param BookModel $bookModel
     * @param array $categoryIds
     * @return boolean
     */
    public static function addBook($bookModel, array $categoryIds) {        
        $db = DatabaseConnection::getDatabase();

        $query = "INSERT INTO books VALUES (:isbn, :title, :author, :price, :quantity)"; // construct statment, append all values from book model
        
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":isbn", $bookModel->isbn);
        $statement->bindValue(":title", $bookModel->title);
        $statement->bindValue(":author", $bookModel->author);
        $statement->bindValue(":price", $bookModel->price);
        $statement->bindValue(":quantity", $bookModel->quantity);
        
        $success = $statement->execute(); // boolean
        
        if($success) { // only add categories if book add was successful
            self::setBookCategories($bookModel->isbn, $categoryIds);
        }
        
        return $success;
    }
    
    /**
     * Sets the categories for a book
     * 
     * @param string $isbn
     * @param array $categoryIds
     */
    public static function setBookCategories($isbn, array $categoryIds) {
        $db = DatabaseConnection::getDatabase();
        
        foreach($categoryIds as $catId) {
            $query = "INSERT INTO bookCategoryAssociation VALUES (:isbn, :catId)";

            $statement = $db->prepare($query); // protect against SQL injection
            $statement->bindValue(":isbn", $isbn);
            $statement->bindValue(":catId", $catId);

            $statement->execute(); // boolean
        }
    }
    
    /**
     * Delete a book from the database
     * 
     * @param string $isbn
     * @return type
     */
    public static function deleteBook($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query1 = "DELETE from bookCategoryAssociation WHERE isbn = :isbn"; // delete all categories for that book
        $query2 = "DELETE from userBasket WHERE isbn = :isbn"; // remove book from user's basket
        $query3 = "DELETE from books WHERE books.isbn = :isbn"; // delete book
        
        $statement1 = $db->prepare($query1); // protect against SQL injection
        $statement1->bindValue(":isbn", $isbn);
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":isbn", $isbn);
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":isbn", $isbn);
        
        $success1 = $statement1->execute();
        $success2 = $statement2->execute();
        $success3 = $statement3->execute();
        
        return $success1 && $success2 && $success3;
    }
    
    /**
     * Returns a book from the database, along with categories.
     * 
     * @param string $isbn
     * @return BOokModel
     */
    public static function getBook($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.*, bookCategories.categoryName 
            FROM books, bookCategories, bookCategoryAssociation
            WHERE bookCategoryAssociation.isbn = books.isbn
            AND bookCategories.categoryId = bookCategoryAssociation.categoryId
            AND books.isbn = :isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":isbn", $isbn);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        $statement->execute();
        $book = $statement->fetch();
        
        return $book;
    }
    
    /**
     * Returns a list of books
     * 
     * @return array
     */
    public static function getBookList() {
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
        
        return $books;
    }
    
    /**
     * Returns a list of all categories for a single book.
     * 
     * @param string $isbn
     * @return array
     */
    public static function getCategoriesForBook($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT DISTINCT bookCategories.* FROM bookCategories, bookCategoryAssociation
                  WHERE bookCategories.categoryId
                  IN (SELECT categoryId FROM bookCategoryAssociation WHERE isbn = :isbn)";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":isbn", $isbn);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookCategoryModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books;
    }
    
    /**
     * Returns a list of all books for a single category.
     * 
     * @param int $categoryId
     * @return array
     */
    public static function getBooksForCategory($categoryId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT books.* FROM books WHERE books.isbn IN
                    (SELECT isbn FROM bookCategoryAssociation WHERE categoryId = :catId)";

        $statement = $db->prepare($query);
        $statement->bindValue(":catId", $categoryId);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookModel');
        
        $statement->execute();
        $books = $statement->fetchAll();
        
        foreach($books as $book) { // set categories for each book
            $bookCats = self::getCategoriesForBook($book->isbn);
            $book->categories = $bookCats;
        }
        
        return $books; // list of all books for that category
    }
    
    /**
     * Increase the quantity for a given book by a set value.
     * 
     * @param string $isbn
     * @param int $quantityToAdd
     * @return bool
     */
    public static function increaseBookQuantity($isbn, $quantityToAdd) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE books SET quantity = quantity + :quantityToAdd WHERE isbn = :isbn";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":isbn", $isbn);
        $statement->bindValue(":quantityToAdd", $quantityToAdd);
        
        return $statement->execute();
    }
    
    /**
     * Decreases the quantity count by 1 for a given book.
     * 
     * @param string $isbn
     * @return bool
     */
    public static function decrementBookQuantity($isbn) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE books SET quantity = quantity - 1 WHERE isbn = :isbn and quantity > 0";
        
        $statement = $db->prepare($query); // protect against SQL injection.
        $statement->bindValue(":isbn", $isbn);
        
        return $statement->execute();
    }
    
}
