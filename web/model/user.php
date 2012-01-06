<?php

class User
{
    private $mUserId = null;
    private $mUserName = null;

    /**
     * User::__construct()
     *
     * @return new User object
     */
    public function __construct($aUserId, $aUserName)
    {
        $this->mUserId = $aUserId;
        $this->mUserName = $aUserName;
    }

    /**
     * User::getUserId()
     *
     * @return int, id of the user
     */
    public function getUserId()
    {
        return $this->mUserId;
    }

    /**
     * User::getUserName()
     *
     * @return string, name of the user
     */
    public function getUserName()
    {
        return $this->mUserName;
    }

}