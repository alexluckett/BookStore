<?php

/**
 * Description of DeleteBook
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteBook extends AuthenticatedAction {
    
    public function execute($requestParams) {        
        $isbn = "";
        
        if(isset($requestParams['isbn'])) {
            $isbn = $requestParams['isbn'];
        }
        
        $success = BookDAO::deleteBookFromDatabase($isbn);
        
        if($success) {
            $_REQUEST['message'] = 'Book: '.$isbn.' deleted';
        } else {
            $_REQUEST['message'] = 'Unable to delete book.';
        }
        
        $_REQUEST["books"] = BookDAO::getBooksFromDatabase();
    }

    public function pageInclude() {
        return "/view/student/bookList.php";
    }
    
}
