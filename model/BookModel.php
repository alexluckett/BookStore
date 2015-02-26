<?php

/**
 * Description of bookModel
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookModel {
    private $isbn;
    private $title;
    private $author;
    private $price;
    private $quantity;
    
    /**
     * Gets a property from the book model.
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
     * Gets a property from the book model.
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
