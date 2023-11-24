<?php

require_once ("config.php");


class TableCreator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
//User Table
    public function createUsersTable()
    {
        $sql_create_table_users = "
            CREATE TABLE IF NOT EXISTS Users (
                user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL,
                role ENUM('admin', 'regular') NOT NULL,
                phone VARCHAR(15) NOT NULL
            )";

        if (mysqli_query($this->conn, $sql_create_table_users)) {
            echo "Table Users created successfully";
        } else {
            echo "Error creating Users table: " . mysqli_error($this->conn);
        }
    }
    //*************************   User Creation     **************************************/
    //user with role
    public function createUserWithRole($username, $email, $password, $phone, $role)
    {
        // Validate input
        if (empty($username) || empty($email) || empty($password) || empty($phone) || empty($role)) {
            echo "Please fill in all fields.";
            exit();
        }

        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $sql = "INSERT INTO Users (username, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("sssss", $username, $email, $hashedPassword, $phone, $role);
        $stmt->execute();

        // Check for success and return a message
        if ($stmt->affected_rows > 0) {
            return "User created successfully!";
        } else {
            return "Error creating user: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    //Create regular user
    public function createRegularUser($username, $email, $password, $phone)
    {
        return $this->createUserWithRole($username, $email, $password, $phone, 'regular');
    }


    //Add Admin
    public function addAdmin($username, $email, $password, $phone)
    {
        return $this->createUserWithRole($username, $email, $password, $phone, 'admin');
    }

    //******************************   Get admin     ***************************
    // Authenticate admin user
    public function authenticateAdmin($username, $password)
    {
        // Prepare the SQL statement
        $sql="SELECT * FROM Users WHERE username = ? AND role = 'admin'";
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if a row is returned
        if ($result->num_rows > 0) {
            $adminData = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $adminData['password'])) {
                // Password is correct
                return true;
            }
        }

        // Close the statement
        $stmt->close();

        // If no matching admin is found or the password is incorrect
        return false;
    }

    //******************************   Get regular user     ***************************
    // Authenticate a regular user
    public function authenticateUser($username, $password)
    {
        // Prepare the SQL statement
        $sql = "SELECT * FROM Users WHERE username = ? AND role = 'regular'";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if a row is returned
        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $userData['password'])) {
                // Password is correct
                return true;
            }
        }

        // Close the statement
        $stmt->close();

        // If no matching user is found or the password is incorrect
        return false;
    }


    //*************        Get regular users with product counts        *****************************
    public function getRegularUsersWithProductCounts()
    {
        // Prepare the SQL statement to join Users and Products tables
        $sql = "SELECT Users.username, COUNT(Products.product_id) AS product_count
                FROM Users
                LEFT JOIN Products ON Users.user_id = Products.creator_id
                WHERE Users.role = 'regular'
                GROUP BY Users.user_id";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch all regular users with product counts
        $usersWithProductCounts = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        return $usersWithProductCounts;
    }


    //*************************   User display    **************************************/

    // Get regular users
    public function getRegularUsers() {
        $users = array();


        $query = "SELECT * FROM Users WHERE  role = 'regular'";

        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    //*************************  Regular User update   **************************************/
    // Modify a regular user
    public function modifyRegularUser($userId, $newUsername, $newEmail, $newPhone)
    {
        // Prepare the SQL statement
        $sql = "UPDATE Users SET username = ?, email = ?, phone = ? WHERE user_id = ? AND role = 'regular'";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("sssi", $newUsername, $newEmail, $newPhone, $userId);
        $stmt->execute();

        // Check for success and return a message
        if ($stmt->affected_rows > 0) {
            return "Regular user modified successfully!";
        } else {
            return "Error modifying regular user: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    //*************************  Regular User delete   **************************************/

    // Delete a regular user
    public function deleteRegularUser($userId)
    {
        // Prepare the SQL statement
        $sql = "DELETE FROM Users WHERE user_id = ? AND role = 'regular'";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Check for success and return a message
        if ($stmt->affected_rows > 0) {
            return "Regular user deleted successfully!";
        } else {
            return "Error deleting regular user: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
    //************************************* Product Table *********************************************//


// Product Table
    public function createProductsTable()
    {
        $sql_create_table_products = "
            CREATE TABLE IF NOT EXISTS Products (
                product_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(50) NOT NULL,
                description TEXT,
                price DECIMAL(10,2) NOT NULL,
                creator_id INT(6) UNSIGNED,
                image VARCHAR(255), -- Assuming the image path or URL
                FOREIGN KEY (creator_id) REFERENCES Users(user_id)
            )";

        if (mysqli_query($this->conn, $sql_create_table_products)) {
            echo "Table Products created successfully";
        } else {
            echo "Error creating Products table: " . mysqli_error($this->conn);
        }
    }

    //******************************* Get products of user *******************************
// Get products associated with a specific user
    public function getProductsByUser($authenticatedUsername)
    {
        // Prepare the SQL statement
        $sql = "SELECT product_name FROM Products 
                JOIN Users ON Products.creator_id = Users.user_id
                WHERE Users.username = ?";

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in preparing the statement: " . $this->conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("s", $authenticatedUsername);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch all products associated with the user
        $userProducts = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        return $userProducts;
    }

}


$tableCreator = new TableCreator($conn);
$tableCreator->createUsersTable();
$tableCreator->createProductsTable();


