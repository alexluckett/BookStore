<?php

/**
 * Adds a quantity number to a book
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddQuantity extends AuthenticatedAction {

    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $this->validateParams($requestParams);
        
        $isbn = $requestParams['isbn'];
        $amountToAdd = $requestParams['amountToAdd'];

        $book = BookDAO::getBook($isbn);
        
        // let view know whether success or not
        if(BookDAO::increaseBookQuantity($isbn, $amountToAdd)) {
            $_REQUEST['messageType'] = "success";
        } else {
            $_REQUEST['messageType'] = "danger";
        }
        
        $_REQUEST['book'] = BookDAO::getBook($isbn); // send updated book back to client page
    }
    
    private function validateParams($requestParams) {
        if (!isset($requestParams['amountToAdd']) || !isset($requestParams['isbn'])) {
            throw new Exception("Please select a book and amount to add.");
        }
        
        if ($requestParams['amountToAdd'] < 0) {
            throw new Exception("Please enter a positive value for amount to add.");
        }
    }

    public function pageInclude() {
        return "/view/staff/viewEditBook.php";
    }

}
