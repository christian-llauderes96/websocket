<?php
require_once("DBH.php");
class Phplogin extends DBH
{
    protected $conn;
    public function __construct()
    {
        parent::__construct(); // Call the parent constructor
        $this->conn = $this->connect();
    }
    public function ValidateUser($uname)
    {
        try {
            // Check if user exists
            $stmt = $this->conn->prepare("SELECT * FROM `w_users` WHERE `id` = ?");
            $stmt->execute([$uname]);
            
            if ($stmt->rowCount() > 0) {
                // Fetch user data
                $user = $stmt->fetch();
                
                // Generate token
                $token = bin2hex(random_bytes(32)) . $uname;
                
                // Update user with token
                $stmt2 = $this->conn->prepare("UPDATE `w_users` SET u_token=? WHERE `id` = ?");
                $stmt2->execute([$token, $uname]);
                
                if ($stmt2->rowCount() > 0) {
                    // Return user data with updated token
                    $user["u_token"] = $token;
                    return $user;
                } else {
                    // Unable to update user
                    return false;
                }
            } else {
                // User not found
                return false;
            }
        } catch (PDOException $e) {
            // Handle database error
            // Log or return false, depending on your error handling strategy
            return false;
        }
    }

}