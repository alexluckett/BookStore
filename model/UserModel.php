<?php

/**
 * Description of userModel
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserModel {
    private $userId;
    private $username;
    private $password;
    private $permission;
    private $permissionString;
    private $accountBalance;
    
    /**
     * Gets a property from the user model.
     * 
     * @param type $property
     * @return type
     */
    public function __get($field) {
        if(property_exists($this, $field)) {
            return $this->$field;
        }
    }
    
    /**
     * Gets a property from the user model.
     * 
     * @param type $property
     * @return type
     */
    public function __set($field, $value) {
        if(property_exists($this, $field)) {
            $this->$field = $value;
        }
    }
    
}
