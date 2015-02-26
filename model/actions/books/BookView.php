<?php

include_once 'model/BookModel.php';

/**
 * Description of BookView
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookView extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $books = $this->getBooksFromDatabase();
        
        $_REQUEST["books"] = $books;
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/student/bookList.php";
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
