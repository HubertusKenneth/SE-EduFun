<?php

class DbConnector {

    var $theQuery;
    var $link;

    public function __construct() {
        ob_start();
        $this->connect();
    }

    function __destruct() {
        mysqli_close($this->link);
        ob_end_flush();
    }

    function DbConnector() {
        $this->connect();
        return $this->link;
    }

    private function connect() {
        $mode = getenv('MODE') ?: 'local';

        switch ($mode) {
            case 'prod':
                $host = 'edufun-db.internal';
                $user = getenv('DB_USER') ?: 'non_root_user';
                $pass = getenv('DB_PASS') ?: '';
                break;

            case 'staging':
                $host = '127.0.0.1';
                $user = getenv('DB_USER') ?: 'root';
                $pass = getenv('DB_PASS') ?: '';
                break;

            case 'local':
            default:
                $host = 'localhost';
                $user = getenv('DB_USER') ?: 'root';
                $pass = getenv('DB_PASS') ?: '';
                break;
        }

        $db = getenv('DB_NAME') ?: 'edufun';

        $this->link = mysqli_connect($host, $user, $pass, $db);
    }

    function query($query) {
        $this->theQuery = $query;
        return mysqli_query($this->link, $query);
    }

    function fetchArray($result) {
        return mysqli_fetch_array($result);
    }

    function close() {
        mysqli_close($this->link);
    }
}
?>

