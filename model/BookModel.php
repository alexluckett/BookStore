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
}