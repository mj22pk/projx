<?php

require_once 'DbHandler.php';
require_once 'Comment.php';
require_once 'User.php';

class CommentHandler
{

    private $_dbHandler;
    
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
    }

    /**
     * CommentHandler::getAllCommentsForSnippet()
     *
     * @return an array with all comments for one snippet
     * together with data of the User object
     */
    public function getAllCommentsForSnippet($snippetId)
    {

        $commentsArray = array();
        $sqlQuery = "   SELECT comment.snippetId, comment.commentId, comment.commentText, comment.userId, user.userName
                        FROM comment
                        INNER JOIN user ON user.userId = comment.userId
                        WHERE snippetId = $snippetId
                        ORDER by comment.commentId DESC
        ";
        $stmt = $this->_dbHandler->PrepareStatement($sqlQuery);
        $stmt->execute();
        $stmt->bind_result($snippetId, $commentId, $commentText, $userId, $userName);

        $objects = array();

        while ($stmt->fetch()) {
            $user = new User($userId, $userName);
            $comment = new Comment($snippetId, $commentId, $userId, $commentText);
            $comment->SetUser($user);
            $objects[] = $comment;
        }
        $stmt->close();

        return $objects;
    }

    /**
     * CommentHandler::addComment()
     *
     * @return true if successful
     * use it if you want to add a new commet för a snippet
     * @param snippetId, commentText and userId
     */
    public function addComment($snippetId, $commentText, $userId)
    {

        $sqlQuery = "INSERT INTO comment (snippetId, commentText, userId) VALUES(?,?,?)";
        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("isi", $snippetId, $commentText, $userId);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * CommentHandler::updateComment()
     *
     * @return true if successful
     * use it if you want to update a comment that exists in the database
     * @param commentId, commentText
     */
    public function updateComment($commentId, $commentText)
    {

        $sqlQuery = "UPDATE comment SET commentText=? WHERE commentId=?";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("si", $commentText, $commentId);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        return false;
    }

    /**
     * CommentHandler::deleteComment()
     *
     * @return true if successful
     * use it if you want to delete a comment
     * @param an id of the comment to delete
     */
    public function deleteComment($commentId)
    {

        $sqlQuery = "DELETE FROM comment WHERE commentId=?";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("i", $commentId);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        return false;
    }

    /**
     * CommentHandler::removeAllComments()
     *
     * @return true if successful
     * taking away all comments from the db
     */
    public function removeAllComments()
    {

        $sqlQuery = "DELETE FROM comment";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    /**
     * CommentHandler::getCommentToEditByCommentId()
     *
     * @return Comment object to edit
     * @param id of the comment you want to edit
     *
     */
    public function getCommentByID($commentId)
    {

        $sqlQuery = "   SELECT comment.snippetId, comment.commentId, comment.commentText, comment.userId, user.userName
                        FROM comment
                        INNER JOIN user ON user.userId = comment.userId
                        WHERE commentId = ?
                    ";
        $stmt = $this->_dbHandler->PrepareStatement($sqlQuery);
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        $stmt->bind_result($snippetId, $commentId, $commentText, $userId, $userName);

        $comment = null;

        if ($stmt->fetch()) {
            $user = new User($userId, $userName);
            $comment = new Comment($snippetId, $commentId, $userId, $commentText);
            $comment->SetUser($user);
        }
        $stmt->close();

        return $comment;
    }

}
