<?php

require_once 'settings.php';

class DbHandler
{

    private $_mySqliObject = null;
    private $_settings = null;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->_settings = new Settings();
        $this->_mySqliObject = new mysqli($this->_settings->GetHost(), $this->_settings->GetUsername(), $this->_settings->GetPassword(), $this->_settings->GetDbName());

        $this->_mySqliObject->set_charset("utf8");

        if (mysqli_connect_errno()) {
            exit();
            return false;
        }
        return true;
    }

    public function __wakeup()
    {
        $this->connect();
    }

    public function close()
    {
        $this->_mySqliObject->Close();
    }

    public function prepareStatement($sqlStatement)
    {
        return $this->_mySqliObject->prepare($sqlStatement);
    }

    public function error()
    {
        return $this->_mySqliObject->error;
    }

}
