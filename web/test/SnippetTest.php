<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/Snippet.php';

class SnippetTest extends UnitTestCase
{

    private $_id;
    private $_author;
    private $_code;
    private $_title;
    private $_desc;
    private $_language;
    private $_snippet;

    public function __construct()
    {
        $this->_author = 'testAuthor';
        $this->_code = 'testCode';
        $this->_title = 'testTitle';
        $this->_desc = 'testDesc';
        $this->_language = 'testLang';
        $this->_id = 0;

        $this->_snippet = new Snippet($this->_author, $this->_code, $this->_title, $this->_desc, $this->_language, $this->_id);
    }

    public function testGetID()
    {
        $this->assertEqual($this->_id, $this->_snippet->getID());
    }

    public function testGetAuthor()
    {
        $this->assertEqual($this->_author, $this->_snippet->getAuthor());
    }

    public function testGetCode()
    {
        $this->assertEqual($this->_code, $this->_snippet->getCode());
    }

    public function testGetTitle()
    {
        $this->assertEqual($this->_title, $this->_snippet->getTitle());
    }

    public function testGetDesc()
    {
        $this->assertEqual($this->_desc, $this->_snippet->getDesc());
    }

    public function testGetLanguage()
    {
        $this->assertEqual($this->_language, $this->_snippet->getLanguage());
    }

}
