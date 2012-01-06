<?php

require_once 'DbHandler.php';
require_once 'Snippet.php';

class SnippetHandler
{

    private $_dbHandler;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
    }

    /**
     *Get a snippet by id
     * @param int $aID id of a snippet
     * @return Snippet
     */
    public function getSnippetByID($id)
    {
        $snippet = null;
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet WHERE id = ?")) {

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->bind_result($snippetID, $author, $code, $title, $desc, $language);
            while ($stmt->fetch()) {
                $snippet = new Snippet($author, $code, $title, $desc, $language, $snippetID);
            }

            $stmt->close();

        }
        $this->_dbHandler->Close();
        return $snippet;
    }

    /**
     * Get all the snippets
     * @return array
     */
    public function getAllSnippets()
    {
        $snippets = array();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet")) {
            $stmt->execute();

            $stmt->bind_result($id, $code, $author, $title, $description, $language);
            while ($stmt->fetch()) {
                $snippet = new Snippet($code, $author, $title, $description, $language, $id);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        return $snippets;
    }

    public function createSnippet(Snippet $snippet)
    {
        $this->_dbHandler->__wakeup();
        $author = $snippet->getAuthor();
        $code = $snippet->getCode();
        $title = $snippet->getTitle();
        $desc = $snippet->getDesc();
        $language = $snippet->getLanguageID();

        if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO snippet (author, code, title, description, language) VALUES (?, ?, ?, ?, ?)")) {
            $databaseQuery->bind_param('sssss', $author, $code, $title, $desc, $language);
            $databaseQuery->execute();
            if ($databaseQuery->affected_rows == null) {
                $databaseQuery->close();
                return false;
            }
            $databaseQuery->close();
        } else {
            return false;
        }

        $this->_dbHandler->close();
        return true;
    }

    public function updateSnippet($snippetName, $snippetCode, $snippetID)
    {
        $databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE SnippetsTable SET snippetName = ?, snippetCode = ? WHERE snippetID = ?");
        $databaseQuery->bind_param('ssi', $snippetName, $snippetCode, $snippetID);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
        return true;
    }

    public function deleteSnippet($snippetID)
    {
        $databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM SnippetsTable WHERE snippetID = ?");
        $databaseQuery->bind_param('i', $snippetID);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
    }

    /**
     * returns a defined number of snippets
     * @param int number of snippets to return
     * @return array with snippets
     */
    public function getNrOfSnippets($nr)
    {
        if($nr == 0) {
            $nr = 1;
        }    
        $snippets = array();
  
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet LIMIT ?")) {
            $stmt->bind_param("i", $nr);
            $stmt->execute();

            $stmt->bind_result($id, $code, $author, $title, $description, $language);
            while ($stmt->fetch()) {
                $snippet = new Snippet($code, $author, $title, $description, $language, $id);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        } else {
            return null;
        }

        $this->_dbHandler->close();

        return $snippets;
    }

    /**
     * returns array with namne and id of language
     * @param int id of language
     * @return Array
     */
    public function getLanguageByID($id)
    {
        $language = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet_language WHERE id = ?")) {

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->bind_result($id, $name);
            while ($stmt->fetch()) {
                $language = array('id' => $id, 'name' => $name);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $language;

    }

    /**
     * returns array with namne and id of all languages
     *@return Array
     */
    public function getLanguages()
    {
        $languages = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet_language")) {
            $stmt->execute();

            $stmt->bind_result($id, $name);
            while ($stmt->fetch()) {
                $language = array('id' => $id, 'name' => $name);
                array_push($languages, $language);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $languages;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function searchByTitle($title) {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language FROM (snippet) WHERE MATCH title AGAINST (?) ")) {
            $stmt->bind_param("s", $title);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }
    
    public function searchByDescription($description) {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language FROM (snippet) WHERE MATCH description AGAINST (?) ")) {
            $stmt->bind_param("s", $description);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }
    
    public function searchByCode($code) {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language FROM (snippet) WHERE MATCH code AGAINST (?) ")) {
            $stmt->bind_param("s", $code);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }
    
    public function fullSearch($q) {
        $titles = array();
        $this->_dbHandler->__wakeup();
        
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language FROM (snippet) WHERE MATCH code,title,description AGAINST (?) ")) {
            $stmt->bind_param("s", $q);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }
    
    
    public function fullSearchWithLang($q, $lang) {
        $titles = array();
        $this->_dbHandler->__wakeup();
        
        $sqlQuery = "   SELECT snippet.id, snippet.author, snippet.code, snippet.title, snippet.description, snippet.language
                        FROM snippet
                        LEFT JOIN snippet_language ON snippet.language = snippet_language.id
                        WHERE MATCH code, title, description
                        AGAINST (?)
                        AND snippet_language.id = ?";
        
        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("si", $q, $lang);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }

}
