<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/Comment.php';

class CommentTest extends UnitTestCase
{

    private $_comment;
    private $_userID;
    private $_snippetID;
    private $_commentID;
    private $_commentText;

    public function __construct()
    {
        $this->_userID = 1;
        $this->_snippetID = 2;
        $this->_commentID = 3;
        $this->_commentText = 'testText';
        $this->_comment = new Comment($this->_snippetID, $this->_commentID, $this->_userID, $this->_commentText);
    }

    public function testGetSetUser()
    {
        $username = 'testname';
        $this->_comment->setUser($username);
        $this->assertEqual($username, $this->_comment->getUser());
    }

    public function testGetSnippetID()
    {
        $this->assertEqual($this->_comment->getSnippetId(), $this->_snippetID);
    }

    public function testGetCommentID()
    {
        $this->assertEqual($this->_comment->getCommentId(), $this->_commentID);
    }

    public function testGetUserID()
    {
        $this->assertEqual($this->_comment->getUserId(), $this->_userID);
    }
    
    public function testGetCommentText() {
        $this->assertEqual($this->_comment->getCommentText(), $this->_commentText);
    }

}
