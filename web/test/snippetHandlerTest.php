<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';

class SnippetHandlerTest extends unitTestcase
{

    private $_snippetHandler;

    function __construct()
    {
        $this->_snippetHandler = new SnippetHandler();
    }

    public function testIfGetSnippetByIDreturnCorrectObject()
    {
        $snippetA = $this->_snippetHandler->getNrOfSnippets(1);
        $snippetB = $this->_snippetHandler->getSnippetByID($snippetA[0]->getID());
        $this->assertEqual($snippetA[0]->getID(), $snippetB->getID());
    }

}
