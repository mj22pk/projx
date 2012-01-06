<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';

/**
 * Runs all tests
 */
class AllTests extends TestSuite
{
    function __construct()
    {
        parent::__construct();
        $this->addFile(dirname(__FILE__) . '/SnippetHandlerTest.php');
        $this->addFile(dirname(__FILE__) . '/CommentTest.php');
        $this->addFile(dirname(__FILE__) . '/FunctionsTest.php');
        $this->addFile(dirname(__FILE__) . '/SnippetTest.php');
    }

}
