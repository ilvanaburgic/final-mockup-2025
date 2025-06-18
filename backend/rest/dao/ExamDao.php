<?php

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
        try {
          /** TODO
           * List parameters such as servername, username, password, schema. Make sure to use appropriate port
           */
          $servername = "127.0.0.1"; //DODANO
            $username = "root"; //DODANO
            $password = "12nana123"; //DODANO
            $dbname = "webfinal"; //DODANO
            $port = 3306; //DODANO

            $this->conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password); //DODANO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //DODANO

          /** TODO
           * Create new connection
           */
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
     * Implement DAO method used to get customer information
     */
    public function get_customers(){
      $stmt = $this->conn->prepare("SELECT * FROM customers"); //DODANO
        $stmt->execute(); //DODANO
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //DODANO
    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {
      //DODANO
      $stmt = $this->conn->prepare("
            SELECT f.name AS food_name, f.brand AS food_brand, DATE(m.created_at) AS meal_date
            FROM meals m
            JOIN foods f ON m.food_id = f.id
            WHERE m.customer_id = ?
        ");
        $stmt->execute([$customer_id]); //DODANO
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //DODANO
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){
      //DODANO
      $stmt = $this->conn->prepare("
            INSERT INTO customers (first_name, last_name, birth_date)
            VALUES (:first_name, :last_name, :birth_date)
        ");
        $stmt->execute($data); //DODANO
        $data['id'] = $this->conn->lastInsertId(); //DODANO
        return $data; //DODANO
    }

    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){

    }
}
?>
