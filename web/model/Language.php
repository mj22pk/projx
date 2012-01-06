<?php

class Language
{

    private $_id;
    private $_language;

    public function __construct($id, $language)
    {

        $this->_id = $id;
        $this->_language = $language;
    }

    /**
     * @return int ID of the snippet
     */
    public function getLangId()
    {
        return $this->_id;
    }

    /**
     * @return String The author of the snippet
     */
    public function getLanguage()
    {
        return $this->_language;
    }
}