<?php

/**
 * A type of action to only be run when the user is authenticated (valid logged in).
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class AuthenticatedAction implements IAction {

    protected $minimumPermissionLevel;

    public function __construct($permissionInteger) {
        $this->minimumPermissionLevel = $permissionInteger;
    }

    public abstract function execute($requestParams);

    public abstract function pageInclude();

    public function isLegalRequest() {
        $result = false;

        if (isset($_SESSION['permission'])) {
            $sessionPermission = $_SESSION['permission'];

            $result = ($sessionPermission <= $this->minimumPermissionLevel); // true if user has required permission level or above
        }

        return $result;
    }

}
