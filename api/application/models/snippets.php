<?php

require_once ('application/helpers/DbHandler.php');
require_once ('application/snippetObject.php');

class Snippets {
	
	private $mDbHandler;

    public function index()
    {
        $this->mDbHandler = new DbHandler();
		
		if(!isset($_GET)) return $this->getAllSnippets();

		if($_GET['lang']) return $this->getLang($_GET['lang']);
		
		return "soo wrong";
		
    }

    /**
     *Get a snippet by id
     * @param int $aID id of a snippet
     * @return Snippet
     */
    public function getSnippetByID($aID)
    {
        $snippet = null;
        if ($stmt = $this->mDbHandler->PrepareStatement("SELECT * FROM snippet WHERE id = ?")) {

            $stmt->bind_param("i", $aID);
            $stmt->execute();

            $stmt->bind_result($id, $author, $code, $title, $desc, $language);
            while ($stmt->fetch()) {
                $snippet = new Snippet($author, $code, $title, $desc, $language, $id);
            }

            $stmt->close();

        }
        $this->mDbHandler->Close();
        return $snippet;
    }
	
	//-------------------------------------------------
	public function getLang($lang)
    {
        $snippets = array();

        $this->mDbHandler->__wakeup();
        if ($stmt = $this->mDbHandler->PrepareStatement("SELECT * FROM snippet WHERE language = ?")) {
            $stmt->bind_param("s", $lang);
			$stmt->execute();

            $stmt->bind_result($id, $code, $author, $title, $description, $language);
            while ($stmt->fetch()) {
                //$snippet = new SnippetObject($code, $author, $title, $description, $language, $id);
				$snippet = array('code' => $code,
								'author' => $author,
								'title' => $title,
								'description' => $description,
								'language' => $language,
								'id' => $id);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        }

        $this->mDbHandler->close();

        return $snippets;
    }
	//-----------------------------------------------------
	
    /**
     * Get all the snippets
     * @return array
     */
    public function getAllSnippets()
    {
        $snippets = array();

        $this->mDbHandler->__wakeup();
        if ($stmt = $this->mDbHandler->PrepareStatement("SELECT * FROM snippet")) {
            $stmt->execute();

            $stmt->bind_result($id, $code, $author, $title, $description, $language);
            while ($stmt->fetch()) {
                //$snippet = new SnippetObject($code, $author, $title, $description, $language, $id);
				$snippet = array('code' => $code,
								'author' => $author,
								'title' => $title,
								'description' => $description,
								'language' => $language,
								'id' => $id);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        }

        $this->mDbHandler->close();

        return $snippets;
    }

    public function createSnippet(Snippet $aSnippet)
    {
        $this->mDbHandler->__wakeup();
        $author = $aSnippet->getAuthor();
        $code = $aSnippet->getCode();
        $title = $aSnippet->getTitle();
        $desc = $aSnippet->getDesc();
        $language = $aSnippet->getLanguage();

        if ($databaseQuery = $this->mDbHandler->PrepareStatement("INSERT INTO snippet (author, code, title, description, language) VALUES (?, ?, ?, ?, ?)")) {
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

        $this->mDbHandler->close();
        return true;
    }

    public function updateSnippet($aSnippetName, $aSnippetCode, $aSnippetID)
    {
        $databaseQuery = $this->mDbHandler->PrepareStatement("UPDATE SnippetsTable SET snippetName = ?, snippetCode = ? WHERE snippetID = ?");
        $databaseQuery->bind_param('ssi', $$aSnippetName, $aSnippetCode, $aSnippetID);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
        return true;
    }

    public function deleteSnippet($aSnippetID)
    {
        $databaseQuery = $this->mDbHandler->PrepareStatement("DELETE FROM SnippetsTable WHERE snippetID = ?");
        $databaseQuery->bind_param('i', $aSnippetID);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
    }
}