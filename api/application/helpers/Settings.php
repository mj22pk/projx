<?php

class Settings
{
    private $m_dbname = "";
    private $m_password = "";
    private $m_host = "";
    private $m_username = "";

    public function __construct()
    {
        $this->m_dbname = "projectx";
        $this->m_host = "localhost";
        $this->m_username = "root";
		$this->m_password = "";
    }

    /**
     * return database name
     * @return string
     */
    public function GetDbName()
    {
        return $this->m_dbname;
    }

    /**
     * return database password
     * @return string
     */
    public function GetPassword()
    {
        return $this->m_password;
    }

    /**
     * return database hostname
     * @return string
     */
    public function GetHost()
    {
        return $this->m_host;
    }

    /**
     * return database usernme
     * @return string
     */
    public function GetUsername()
    {
        return $this->m_username;
    }

}
