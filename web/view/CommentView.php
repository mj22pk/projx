<?php
require_once dirname(__file__) . '/../model/Captcha.php';

class CommentView
{
    /**
     * CommentView::doCommentForm()
     * html form for adding a new comment
     * @return String
     */
    public function doCommentForm()
    {
        $captcha = new Captcha();
        $form = ("
                    <form action='' method='POST'>
                        <label for='commentText'>Kommentar: </label><br/>
                        <textarea name='commentText' rows = '5' cols ='40' maxlength='1500'></textarea>
                        <br/>
                        <label for='author'>Namn:(ange siffran 6 så länge)</label><br/>
                        <input type='text' name='commentAuthor' value = ''/>
                        <br/>
                        <img src='secure.jpg' alt='Captcha image'/><br/>
                        <label for='secure'>Ange svaret till bilden:</label><br/>
                        <input type='text' name='secure' value='' /><br/>
                        <input type='submit' name='submitComment' value='Skriv'/>
                    </form>
                    ");
        return $form;
    }

    /**
     * CommentView::showAllCommentsForSnippet()
     * html that shows all comments taht was added for a snippet
     * @return String
     * @parram array of the Comment object
     */
    public function showAllCommentsForSnippet($comments)
    {
        $message = "";
        if (!empty($comments)) {
            for ($i = 0; $i < count($comments); $i++) {
                $message .= "<div>";
                $message .= "<p>kommentar till snippetId: " . $comments[$i]->getSnippetId() . "</p>";
                $message .= "<p>komentarens text: " . $comments[$i]->getCommentText() . "</p>";
                $message .= "<p> Kommentaren skrivet av: " . $comments[$i]->getUser()->getUserName() . "</p>";
                $message .= "</div>";

                $message .= "<a onclick=\"javascript: return confirm('Vill du verkligen ta bort kommentar? [" . $comments[$i]->getCommentId() . "]')\" href='index.php?snippet=" . $comments[$i]->getSnippetId() . "&controller=commentcontroller&deleteComment=" . $comments[$i]->getCommentId() . "'>Radera</a>";

                $message .= "</br><a onclick=\"javascript: return confirm('Vill du verkligen editera kommentar? [" . $comments[$i]->getCommentId() . "]')\" href='index.php?snippet=" . $comments[$i]->getSnippetId() . "&controller=commentcontroller&editComment=" . $comments[$i]->getCommentId() . "'>Redigera</a>";

                $message .= "</br>";
                $message .= "<hr>";
            }
        } else {
            $message .= "<br/>Det finns inga kommentarer för denna snippet.";
        }

        return $message;
    }

    /**
     * CommentView::editComment()
     * html taht allows to edit a comment text
     * @param Comment object
     * @return String
     */
    public function editComment($comment)
    {
        if ($comment) {
            $form = "
                        <form action='' method='POST'>
                        <label for='commentText'>Kommentar: </label><br/>
                        <textarea name='commentText' rows ='5' cols ='40' maxlength='1500'>" . $comment->getCommentText() . "</textarea>
                        <br/>
                        <label for='author'>Namn:(man kan ej redigera vem som skrev, det är redan skrivet av någon)</label><br/>
                        <input type='text' name='commentAuthor' readonly='readonly' value = '" . $comment->getUser()->getUserName() . "'/>
                        <br/>
                        <input type='submit' name='updateComment' value='Skriv'/>
                        </form>
                        ";
        } else {
            $form = "Kommentaren du försöker redigera finns inte!";
        }
        return $form;
    }

    /**
     * CommentView::triedToSubmitComment()
     *
     * @return true if user is trying to add a new comment
     */
    public function triedToSubmitComment()
    {
        if (isset($_POST['submitComment'])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::getCommentText()
     *
     * @return String that is the text of the comment
     */
    public function getCommentText()
    {
        if (isset($_POST['commentText'])) {
            return trim($_POST['commentText']);
        }
        return false;
    }

    /**
     * CommentView::getAuthorId()
     *
     * @return int, id of the User
     */
    public function getAuthorId()
    {
        if (isset($_POST['commentAuthor'])) {
            return trim($_POST['commentAuthor']);
        }
        return false;
    }

    /**
     * CommentView::getCaptchaAnswer()
     *
     * @return
     */
    public function getCaptchaAnswer()
    {
        if (isset($_POST['secure'])) {
            return trim($_POST['secure']);
        } 
        
        return false;
    }

    /**
     * CommentView::triesToRemoveComment()
     *
     * @return true if user is trying to delete a comment
     */
    public function triesToRemoveComment()
    {
        if (isset($_GET["deleteComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichCommentToDelete()
     *
     * @return int, id of the comment that is going to be deleted
     */
    public function whichCommentToDelete()
    {
        if (isset($_GET["deleteComment"])) {
            return urldecode($_GET["deleteComment"]);
        }
        return false;
    }

    /**
     * CommentView::triesToEditComment()
     *
     * @return true if the user is trying to edit a comment
     */
    public function triesToEditComment()
    {
        if (isset($_GET["editComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichCommentToEdit()
     *
     * @return int, id of the comment that user wants to edit
     */
    public function whichCommentToEdit()
    {
        if (isset($_GET["editComment"])) {
            return urldecode($_GET["editComment"]);
        }
        return false;
    }

    /**
     * CommentView::triesToUpdateComment()
     *
     * @return true if user wants to update comment
     */
    public function triesToUpdateComment()
    {
        if (isset($_POST["updateComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichSnippetToComment()
     *
     * @return int, id of the snippet for which user wants to add a new comment
     */
    public function whichSnippetToComment()
    {
        if (isset($_GET["snippet"])) {
            return urldecode($_GET["snippet"]);
        }
        return false;
    }

}
