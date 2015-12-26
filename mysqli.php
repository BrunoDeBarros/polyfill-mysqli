<?php
/*
 * This file provides a MySQLi polyfill for PHP installations that don't have it installed.
 *
 * (c) Bruno De Barros <bruno@terraduo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

final class mysqli {

    protected $connection;
    public $connect_error;
    public $connect_errno;
    public $error;

    function __construct($host, $user, $pass, $db, $port) {
        $this->connection = mysql_connect($host . ":" . $port, $user, $pass, true);

        if ($this->connection) {
            if (!mysql_select_db($db, $this->connection)) {
                $this->connect_error = mysql_errno($this->connection);
                $this->connect_errno = mysql_error($this->connection);
            }
        } else {
            $this->connect_error = mysql_errno();
            $this->connect_errno = mysql_error();
        }
    }

    function query($sql) {
        $result = mysql_query($sql, $this->connection);
        if (!$result) {
            $this->error = mysql_error($this->connection);

            return false;
        } else {
            return new MySQL_Result($result);
        }
    }

    function multi_query($sql) {
        foreach (explode(";", $sql) as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$this->query($query)) {
                    return false;
                }
            }
        }

        return true;
    }

}

class mysqli_result {

    protected $result;
    public $num_rows;

    function __construct($result) {
        $this->result = $result;
        $this->num_rows = is_resource($result) ? mysql_num_rows($result) : null;
    }

}