<?php

include_once 'model/utils/FileSaver.php';
include_once 'model/utils/StringUtils.php';

/**
 * Adds a book into the system.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddBook extends AuthenticatedAction {
    const UPLOAD_DIRECTORY = "view/images/bookcovers/useruploads";
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }
    
    public function execute($requestParams) { 
        $bookModel = $this->constructBook($requestParams);
        $categoryId = $requestParams['categories'];
        
        $success = false;
        
        try {
            $success = BookDAO::addBook($bookModel, $categoryId);
            $_REQUEST['message'] = 'Book: '.$bookModel->isbn.' added';
            $_REQUEST['alertType'] = 'success';
        } catch (Exception $ex) {
            $_REQUEST['message'] = 'Unable to add book. Ensure ISBN is not already in the system.';
        }

        if($success) {
            $this->uploadFile($bookModel); // only upload if book was added
        }
        
        $_REQUEST['books'] = BookDAO::getBookList();
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
    }
    
    /**
     * Uploads the cover image for a book.
     * 
     * @param type $book
     */
    private function uploadFile($book) {
        $uploadedFile = $_FILES['uploadedFile'];
        
        $fileType = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION); // extract file type from full path
        $uploadedFile['name'] = $book->isbn.".".$fileType; // all file names must be the book's ISBN
        
        $permittedFileTypes = array("png"); // restricted to php for now, but can be extended
        
        try {
            $fileUploader = new FileSaver(self::UPLOAD_DIRECTORY, $permittedFileTypes);
            $fileUploader->saveFile($uploadedFile);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage()." Placeholder cover photo will be used."); // apend specialised error message to exception
        }
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }
    
    /**
     * Constructs a book model from the given parameters.
     * @param type $requestParams
     * @return \BookModel
     */
    private function constructBook($requestParams) {
        $book = new BookModel();

        $book->setIsbn($requestParams['isbn']);
        $book->setTitle($requestParams['title']);
        $book->setAuthor($requestParams['author']);
        $book->setPrice($requestParams['price']);
        $book->setQuantity($requestParams['quantity']);
        $book->categories = $requestParams['categories'];

        return $book;
    }
    
}