<?php

require(__DIR__ . '/../Config/init.php');

class Product extends Model
{
    /**
     * Constructor that calls the parent constructor and sets the table name for this class.
     * $this->tableName is refers to the table name in the database which will be used by this model.
     * $this->setTableName is a method from the parent class that sets the table name.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('products');
    }

    /**
     * Method to get all products along with their category names.
     */
    public function getAllProducts()
    {
        $query = "SELECT products.*, categories.category_name 
                  FROM {$this->tableName} 
                  INNER JOIN categories ON products.category_id = categories.id 
                  WHERE products.isDeleted = 0";
        $stmt = $this->db->getInstance()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get product by ID.
     * @param int $id - Product ID
     */
    public function getProductById($id)
    {
        return $this->db->selectData($this->tableName, $id);
    }

    /**
     * Create a new product.
     * @param array $data - Product data
     */
    public function createProduct($data)
    {
        return $this->db->insertData($this->tableName, $data);
    }

    /**
     * Update an existing product.
     * @param int $id - Product ID
     * @param array $data - Data to update
     */
    public function updateProduct($id, $data)
    {
        return $this->db->updateData($this->tableName, $id, $data);
    }

    /**
     * Soft-delete a product.
     * @param int $id - Product ID
     */
    public function deleteProduct($id)
    {
        return $this->db->deleteRecord($this->tableName, $id);
    }

    /**
     * Restore all soft-deleted products.
     */
    public function restoreProduct($id)
    {
        return $this->db->restoreRecord($this->tableName);
    }
}
