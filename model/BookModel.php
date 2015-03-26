<?php

/**
 * Represents a book
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class BookModel extends DomainModel {
    protected $isbn;
    protected $title;
    protected $author;
    protected $price;
    protected $quantity;
    protected $categories;
    
    public function setIsbn($isbn) {
        if(StringUtils::isAlphabetical($isbn)) {
            throw new InvalidArgumentException("ISBN cannot contain letters.");
        }
        
        $newIsbn = StringUtils::stripSymbols($isbn); // strips all remaining symbols out of ISBN, e.g: 970-XXXXX turns to 970XXXXX
                
        if(strlen($newIsbn) !== 10 && strlen($newIsbn) !== 13) {
            throw new InvalidArgumentException("ISBN must be 10 or 13 characters.");
        }
        
        $this->isbn = $newIsbn;
    }
    
    public function setTitle($title) {
        if(!preg_match("/[a-z]|[0-9]{1,128}/i", $title)) {
            throw new InvalidArgumentException("Title must be alphanumeric.");
        }
        
        $this->title = $title;
    }
    
    public function setAuthor($author) {
        if(!preg_match("/[a-z]{1,128}/i", $author)) {
            throw new InvalidArgumentException("Author name must be letters, between 1-128 characters.");
        }
        
        $this->author = $author;
    }
    
    public function setPrice($price) {
        if(!StringUtils::isNumeric($price)) {
            throw new InvalidArgumentException("Price must be a number.");
        }
        
        if($price < 1) {
            throw new InvalidArgumentException("Please enter a positive value for price .");
        }
        
        $this->price = $price;
    }
    
    public function setQuantity($quantity) {
        if(!StringUtils::isNumeric($quantity)) {
            throw new InvalidArgumentException("Price must be a number");
        }
        
        if($quantity < 1) {
            throw new InvalidArgumentException("Please enter a positive value for quantity.");
        }
        
        $this->quantity = $quantity;
    }
    
    
}