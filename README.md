# final-mockup-2025

## STEP 1: Conection with database : (/connection-check)

**ExamDao.php:**

```php
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
```


**ExamRoutes.php:**

```php
Flight::route('GET /connection-check', function(){
    new ExamDao(); //DODANO
});
```

## STEP 2: get customer information

**ExamDao.php:**

```php
  --get customer information--
public function get_customers(){
  $stmt = $this->conn->prepare("SELECT * FROM customers"); //DODANO
  $stmt->execute(); //DODANO
  return $stmt->fetchAll(PDO::FETCH_ASSOC); //DODANO
}
```

**ExamRoutes.php:**

```php
Flight::route('GET /customers', function(){
  Flight::json(Flight::examService()->get_customers());
});
```

**ExamServices.php:**

```php
public function get_customers(){
  return $this->dao->get_customers(); //DODANO
}
```

##STEP 3: returns array of all meals for a specific customer
```php
**ExamDao.php:**

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
```

**ExamRoutes.php:**
```php
Flight::route('GET /customer/meals/@customer_id', function($customer_id){
  Flight::json(Flight::examService()->get_customer_meals($customer_id)); //DODANO
});
```

**ExamServices.php:**
```php
public function get_customer_meals($customer_id){
  return $this->dao->get_customer_meals($customer_id); //DODANO
}
```

## STEP 4: add the customer to the database POST /customers/add

**ExamDao.php**
```php
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
```

**ExamRoutes.php:**
```php
Flight::route('POST /customers/add', function() {
  $data = Flight::request()->data->getData(); //DODANO
  Flight::json(Flight::examService()->add_customer($data)); //DODANO
});
```

**ExamService.php:**
```php
public function add_customer($customer){
  return $this->dao->add_customer($customer); //DODANO
}
```

## STEP 5: return the array of all foods from the database together with the image of the foods. - Fully paginated GET /foods/report

**ExamDao.php**
```php
public function get_foods_report(){
      //DODANO
      $stmt = $this->conn->prepare("
            SELECT 
                f.name,
                f.brand,
                CONCAT('<img src=\"', f.image_url, '\" width=\"100\" />') AS image,
                SUM(CASE WHEN n.name = 'Energy' THEN fn.quantity ELSE 0 END) AS energy,
                SUM(CASE WHEN n.name = 'Protein' THEN fn.quantity ELSE 0 END) AS protein,
                SUM(CASE WHEN n.name = 'Fat' THEN fn.quantity ELSE 0 END) AS fat,
                SUM(CASE WHEN n.name = 'Fiber' THEN fn.quantity ELSE 0 END) AS fiber,
                SUM(CASE WHEN n.name = 'Carb' THEN fn.quantity ELSE 0 END) AS carbs
            FROM foods f
            LEFT JOIN food_nutrients fn ON f.id = fn.food_id
            LEFT JOIN nutrients n ON fn.nutrient_id = n.id
            GROUP BY f.id
            LIMIT 50
        ");
        $stmt->execute(); //DODANO
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //DODANO
    }
```

**ExamRoutes.php:**
```php
Flight::route('GET /foods/report', function(){
  Flight::json(Flight::examService()->foods_report()); //DODANO
});
```

**ExamServices.php:**
```php
public function foods_report(){
  return $this->dao->get_foods_report(); //DODANO
}
```
