<?php

/**
 * A type of action to only be run when the user is authenticated (valid logged in).
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class AuthenticatedAction implements IAction {
    
    /* permission levels */
    const staffPermission = 1;
    const userPermission = 2;

    protected $minimumPermissionLevel;

    /**
     * Initialises the AuthenticatedAction with a minimum permission level.
     * 
     * @param int $permissionInteger
     */
    public function __construct($permissionInteger) {
        $this->minimumPermissionLevel = $permissionInteger;
    }

    /**
     * Responsible for action execution, called before page output.
     * Should initialise output variables for the view to utilise.
     */
    public abstract function execute($requestParams);

    /**
     * Returns a string representing the file to include after execution.
     * Should be relative to path of index.php.
     */
    public abstract function pageInclude();

    /**
     * Used to confirm if user can execute this action. Action will be executed
     * depending on true/false return value.
     * 
     * @return boolean
     */
    public function isLegalRequest() {
        $result = false;

        if (isset($_SESSION['permission'])) {
            $sessionPermission = $_SESSION['permission'];

            $result = ($sessionPermission <= $this->minimumPermissionLevel); // true if user has required permission level or above
        }

        return $result;
    }

}
