<?php

require_once 'DbHandler.php';
require_once 'Language.php';

class LanguageHandler
{

    private $_dbHandler;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
    }

    public function getAllLang()
    {
        $langs = array();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet_language")) {
            $stmt->execute();

            $stmt->bind_result($id, $language);
            while ($stmt->fetch()) {
                $lang = new Language($id, $language);
                array_push($langs, $lang);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        return $langs;
    }
}