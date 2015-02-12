<?php
abstract class DBAbstractModel {

    private static $db_host = '127.0.0.1';
    private static $db_user = 'root';
    private static $db_pass = 'austria';
    protected $db_name = '';
    protected $query;
    protected $rows = array();
    private $conn;
    public $mensaje = 'Hecho';
    protected $error_conn=false;
    public $error_query;

    # métodos abstractos para ABM de clases que hereden    
    abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();
 
    # los siguientes métodos pueden definirse con exactitud y no son abstractos
	# Conectar a la base de datos
	private function open_connection() {
		
	    $this->conn = new mysqli(self::$db_host, self::$db_user, 
	                             self::$db_pass, $this->db_name);
	  
		if($conn->connect_errno){
			die('Error de conexion'. mysqli_connect_errno());
			$this->error_conn = true;
		}	                        
	}

	# Desconectar la base de datos
	private function close_connection() {
		$this->conn->close();
	}

	# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
	protected function execute_single_query() {
	    if($_POST) {
	        $this->open_connection();
	        $this->conn->query($this->query);
	        $this->close_connection();
	    } else {
	        $this->mensaje = 'Metodo no permitido';
	    }
	}

	# Traer resultados de una consulta en un Array
	protected function get_results_from_query() {
        $this->open_connection();
        $result = $this->conn->query($this->query);
        while ($this->rows[] = $result->fetch_assoc());
        $result->close();
        $this->close_connection();
        array_pop($this->rows);
	}
}
?>
