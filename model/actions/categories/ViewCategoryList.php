<?php

/**
 * Description of ViewCategoryList
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewCategoryList extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }

    public function execute($requestParams) {
        $_REQUEST["categories"] = CategoryDAO::getBookCategories(); // send category list to view
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/staff/viewCategories.php";
    }

}