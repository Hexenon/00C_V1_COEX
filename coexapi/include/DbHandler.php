<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /* ------------- `users` table method ------------------ */

    /**
     * Creating new user
     * @param String $name User full name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser($name, $email, $password) {
        require_once 'PassHash.php';
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);
            $full_salt = substr($hash, 0, 29);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO members(id, username, email, password_hash, api_key, salt, status) values(-1, ?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("sssss", $name, $email, $password_hash, $api_key, $full_salt);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }

    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($email, $password) {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT password_hash FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the email
            // Now verify the password

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user not existed with the email
            return FALSE;
        }
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT id from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT name, email, api_key, status, created_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($name, $email, $api_key, $status, $created_at);
            $stmt->fetch();
            $user = array();
            $user["name"] = $name;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["status"] = $status;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT id from users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /* ------------- `items` table method ------------------ */

    /**
     * Creating new item
     * @param String $user_id user id to whom item belongs to
     * @param String $item item text
     */
    public function createItem($user_id, $item) {
        $stmt = $this->conn->prepare("INSERT INTO items(item) VALUES(?)");
        $stmt->bind_param("s", $item);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            // item row created
            // now assign the item to user
            $new_item_id = $this->conn->insert_id;
            $res = $this->createUseritem($user_id, $new_item_id);
            if ($res) {
                // item created successfully
                return $new_item_id;
            } else {
                // item failed to create
                return NULL;
            }
        } else {
            // item failed to create
            return NULL;
        }
    }

    /**
     * Fetching single item
     * @param String $item_id id of the item
     */
    public function getItem($item_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT t.id, t.item, t.status, t.created_at from items t, user_items ut WHERE t.id = ? AND ut.item_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $item_id, $user_id);
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id, $item, $status, $created_at);
            // TODO
            // $item = $stmt->get_result()->fetch_assoc();
            $stmt->fetch();
            $res["id"] = $id;
            $res["item"] = $item;
            $res["status"] = $status;
            $res["created_at"] = $created_at;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching all user items
     * @param String $user_id id of the user
     */
    public function getAllUserItems($user_id) {
        $stmt = $this->conn->prepare("SELECT t.* FROM items t, user_items ut WHERE t.id = ut.item_id AND ut.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $items = $stmt->get_result();
        $stmt->close();
        return $items;
    }

    /**
     * Updating item
     * @param String $item_id id of the item
     * @param String $item item text
     * @param String $status item status
     */
    public function updateItem($user_id, $item_id, $item, $status) {
        $stmt = $this->conn->prepare("UPDATE items t, user_items ut set t.item = ?, t.status = ? WHERE t.id = ? AND t.id = ut.item_id AND ut.user_id = ?");
        $stmt->bind_param("siii", $item, $status, $item_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /**
     * Deleting a item
     * @param String $item_id id of the item to delete
     */
    public function deleteItem($user_id, $item_id) {
        $stmt = $this->conn->prepare("DELETE t FROM items t, user_items ut WHERE t.id = ? AND ut.item_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $item_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /* ------------- `user_items` table method ------------------ */

    /**
     * Function to assign a item to user
     * @param String $user_id id of the user
     * @param String $item_id id of the item
     */
    public function createUserItem($user_id, $item_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_items(user_id, item_id) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $item_id);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }

}

?>
