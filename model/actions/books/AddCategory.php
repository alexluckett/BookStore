<?php

/**
 * Description of AddCategory
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddCategory extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        $categoryName = $requestParams['categoryName'];
        
        $message = "Category ".$categoryName." successfully created.";
        $messageType = "success";
        
        try {
            CategoryDAO::createCategory($categoryName);
        } catch (Exception $ex) {
            $message = "Error creating cateogry: category already exists.";
            $messageType = "danger";
        }
        
        $_REQUEST['message'] = $message;
        $_REQUEST['messageType'] = $messageType;
    }

    public function pageInclude() {
        return "/view/staff/addCategoryPage.php";
    }

}
