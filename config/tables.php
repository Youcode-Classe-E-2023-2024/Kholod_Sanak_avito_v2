<?php

require_once ("config.php");


class TableCreator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createUsersTable()
    {
        $sql_create_table_users = "
            CREATE TABLE IF NOT EXISTS Users (
                user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(100) NOT NULL,
                role ENUM('admin', 'regular') NOT NULL,
                phone VARCHAR(15) NOT NULL
            )";

        if (mysqli_query($this->conn, $sql_create_table_users)) {
            echo "Table Users created successfully";
        } else {
            echo "Error creating Users table: " . mysqli_error($this->conn);
        }
    }

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
}


$tableCreator = new TableCreator($conn);
$tableCreator->createUsersTable();
$tableCreator->createProductsTable();


