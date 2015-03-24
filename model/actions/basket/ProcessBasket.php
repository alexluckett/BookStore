<?php

/**
 * Processes all items in a user's basket. If successful, it will deduct
 * the prices from the user's account and decrement the quantities.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ProcessBasket extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }

    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $user = UserDAO::getUser($userId);
        $books = BasketDAO::getBooksFromBasket($userId);

        $messageType = "success";
        $errorMessages = [];

        foreach ($books as $book) {
            try {
                $user = UserDAO::getUser($userId); // return updated user after modification
                $this->processItem($book, $user);
            } catch (Exception $ex) {
                $messageType = "danger";
                array_push($errorMessages, $ex->getMessage()); // log all error messages
            }
        }
        
        $_REQUEST['user'] = $user;
        $_REQUEST['messageType'] = $messageType;
        $_REQUEST['messages'] = $errorMessages;
    }

    public function pageInclude() {
        return "/view/staff/viewOrderConfirmation.php";
    }

    private function processItem($item, $user) {
        if ($item->quantity == 0) {
            throw new Exception("No \"" . $item->title . "\" left in stock");
        }

        $balance = ($user->accountBalance - $item->price);

        if ($balance < 0) {
            throw new Exception("Insufficient funds to purchase book: " . $item->title);
        }

        UserDAO::updateUserBalance($user->userId, $balance);
        BasketDAO::removeFromBasket($user->userId, $item->isbn);
        BookDAO::decrementBookQuantity($item->isbn);
    }

}
