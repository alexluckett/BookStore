<?php

/**
 * Description of ProcessBasket
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ProcessBasket extends AuthenticatedAction {
    
    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $books = BasketDAO::getBooksFromBasket($userId);
        
        
    }

    public function pageInclude() {
        
    }
    
    private function processItem($item, $user) {
        if($item->quantity == 0) {
            throw new Exception("No \"".$item->title."\" left in stock");
        }
        
        if($user->accountBalance < $item->price) {
            throw new Exception("Insufficient funds to purchase book: ".$item->title);
        }
        
        
    }

}
