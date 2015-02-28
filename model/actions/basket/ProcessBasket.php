<?php

/**
 * Description of ProcessBasket
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ProcessBasket extends AuthenticatedAction {

    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $user = UserDAO::getUserFromDatabase($userId);
        $books = BasketDAO::getBooksFromBasket($userId);

        $messageType = "success";
        $errorMessages = [];

        foreach ($books as $book) {
            try {
                $user = UserDAO::getUserFromDatabase($userId); // return updated user after modification
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
        return "/view/staff/orderConfirmation.php";
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
        BookDAO::decrementQuantity($item->isbn);
    }

}
