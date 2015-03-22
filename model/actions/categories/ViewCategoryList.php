<?php

/**
 * Description of ViewCategoryList
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewCategoryList extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
    }

    /**
     * @return string
     */
    public function pageInclude() {
        return "/view/staff/viewCategories.php";
    }

}