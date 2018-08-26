<?php

/**
 * A class designed to model all DomainModels (should map roughly to database tables).
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class DomainModel {

    /**
     * Gets a property from the book model.
     * 
     * @param type $property
     * @return type
     */
    public function __get($field) {
        if (property_exists($this, $field)) {
            return $this->$field;
        }
    }

    /**
     * Gets a property from the book model.
     * 
     * @param type $property
     * @return type
     */
    public function __set($field, $value) {
        if (property_exists($this, $field)) {
            $this->$field = $value;
        }
    }

}
