<?php

/**
 * Represents a user
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserModel extends DomainModel {
    protected $userId;
    protected $username;
    protected $password;
    protected $permission;
    protected $permissionString;
    protected $accountBalance;    
}