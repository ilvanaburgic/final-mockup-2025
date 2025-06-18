# final-mockup-2025

FIRST STEP:

Conection with database : (/connection-check)

ExamDao.php:

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


ExamRoutes.php:

Flight::route('GET /connection-check', function(){
    new ExamDao(); //DODANO
});