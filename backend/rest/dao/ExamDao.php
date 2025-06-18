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

    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {

    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){

    }

    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){

    }
}
?>
