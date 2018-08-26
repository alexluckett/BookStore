<?php

/**
 * Abstraction layer for database communication relating to book categories.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class CategoryDAO {
    
    /**
     * Create a new category in the db.
     * 
     * @param string $categoryName
     * @return bool
     */
    public static function createCategory($categoryName) {
        $db = DatabaseConnection::getDatabase();
        
        $query = "INSERT INTO bookCategories VALUES(DEFAULT, :categoryName)";
        
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":categoryName", $categoryName);
        
        return $statement->execute();
    }
    
    /**
     * Delete a book category.
     * 
     * @param int $categoryId
     * @return bool
     */
    public static function deleteCategory($categoryId) {
        $db = DatabaseConnection::getDatabase();
        
        $query = "DELETE FROM bookCategories WHERE categoryId = :categoryId";
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":categoryId", $categoryId);
        
        return $statement->execute();
    }
    
    /**
     * Get a list of all book categories.
     * 
     * @return bool
     */
    public static function getBookCategories() {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT * FROM bookCategories";

        $statement = $db->prepare($query);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'BookCategoryModel');
        $statement->execute();
        $books = $statement->fetchAll();
        
        return $books; // list of all categories
    }
    
}
