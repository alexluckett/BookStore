<?php

/**
 * Adds a new book category
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddCategory extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }
    
    public function execute($requestParams) {
        $categoryName = $requestParams['categoryName'];
        
        $message = "Category ".$categoryName." successfully created.";
        $messageType = "success";
        
        try {
            CategoryDAO::createCategory($categoryName);
        } catch (Exception $ex) {
            $message = "Error creating cateogry: category already exists."; // error message for view
            $messageType = "danger";
        }
        
        $_REQUEST['message'] = $message;
        $_REQUEST['messageType'] = $messageType;
    }

    public function pageInclude() {
        return "/view/staff/addCategoryPage.php";
    }

}
