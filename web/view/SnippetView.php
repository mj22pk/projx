<?php
require_once dirname(__FILE__) . '/../model/Functions.php';

class SnippetView
{
    /**
     * return html code for a single snippet
     * @param Snippet a snippet Object
     * @return String
     */
    public function singleView($snippet)
    {

        $sh = new Functions();

        $html = "<h2>" . $snippet->getTitle() . "</h2>
		<div class='snippet-desc'>
			<p>" . $snippet->getDesc() . "</p>	
		</div>
		<div class='snippet-code'>
			<code>" . $sh->geshiHighlight($snippet->getCode(), $snippet->getLanguage()) . "</code>
		</div>
		<div class='snippet-author'>
			<span>" . $snippet->getAuthor() . "</span>
		</div>";

        return $html;
    }

    /**
     * Transform an array of snippets to html-code
     * @param array $aSnippets is an array of snippets
     * @return string
     */
    public function listView($snippets)
    {
        $html = '';

        foreach ($snippets as $snippet) {
            $html .= '
                <div class="snippet-list-item">
                    <div class="snippet-title">
                        <h3><a href="?snippet=' . $snippet->getID() . '">' . $snippet->getTitle() . '</a></h3>
                    </div>
                    <div class="snippet-description">
                        <p>' . $snippet->getDesc() . '</p>
                    </div>
                    <div class="snippet-author">
                        <p>Posted by: <i>' . $snippet->getAuthor() . '</i></p>
                    </div>
                </div>
            ';
        }

        return $html;
    }

    public function createSnippet($languages)
    {
        $view = '
            <div id="createSnippetContainer">
                <form action="" method="post">
                    <div id="createSnippetNameDiv">
                        <p>Title:</p>
                        <input type="text" name="snippetTitle" id="createSnippetNameInput" />
                        <p>Description:</p>
                        <input type="text" name="snippetDescription" id="createSnippetNameInput" />
                        <p>Language:</p>
                        <select name="snippetLanguage">';
        foreach ($languages as &$languages) {
            $view .= '<option value="' . $languages['id'] . '">' . $languages['name'] . '</option>';
        }
        $view .= '</select>    
                    </div>

                    <div id="createSnippetCodeDiv">
                        <p>Snippet:</p>
                        <textarea cols="50" rows="20" name="createSnippetCodeInput" id="createSnippetCodeInput"></textarea>
                    </div>

                    <div id="createSnippetButton">
                        <input type="submit" name="createSnippetSaveButton" id="createSnippetSaveButton" value="Create snippet" />
                    </div>
                </form>
            </div>
        ';
        return $view;
    }


    public function updateSnippet($snippet)
    {
        $view = '
			<div id="updateSnippetContainer">
				<form action="" method="post">
					<div id="updateSnippetNameDiv">
						<p>Name:</p>
						<input type="text" name="updateSnippetNameInput" id="updateSnippetNameInput" value="' . $snippet[0]->getTitle() . '" /> 
					</div>

					<div id="updateSnippetCodeDiv">
						<p>Snippet:</p>
						<textarea cols="50" rows="50" name="updateSnippetCodeInput" id="updateSnippetCodeInput">' . $snippet[0]->getCode() . '</textarea>
					</div>

					<div id="updateSnippetButton">
						<input type="hidden" name="updateSnippetID" value="' . $snippet[0]->getID() . '" />
						<input type="submit" name="updateSnippetUpdateButton" id="updateSnippetUpdateButton" value="Update snippet" />
					</div>
				</form>
			</div>
		';
        return $view;
    }

    public function triedToCreateSnippet()
    {
        if (isset($_POST['createSnippetSaveButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getCreateSnippetName()
    {
        $snippetName = $_POST['createSnippetNameInput'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetTitle()
    {
        $snippetName = $_POST['snippetTitle'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetDescription()
    {
        $snippetName = $_POST['snippetDescription'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetLanguage()
    {
        $snippetName = $_POST['snippetLanguage'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getCreateSnippetCode()
    {
        $snippetCode = $_POST['createSnippetCodeInput'];
        if ($snippetCode == null) {
            return null;
        } else {
            return $snippetCode;
        }
        return false;
    }

    public function triedToChangeSnippet()
    {
        if (isset($_GET['chsnippet'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getSnippetIDLink()
    {
        $snippetID = $_GET['chsnippet'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
        return false;
    }

    public function triedToSaveSnippet()
    {
        if (isset($_POST['updateSnippetUpdateButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUpdateSnippetName()
    {
        $snippetName = $_POST['updateSnippetNameInput'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
    }

    public function getUpdateSnippetCode()
    {
        $snippetCode = $_POST['updateSnippetCodeInput'];
        if ($snippetCode == null) {
            return null;
        } else {
            return $snippetCode;
        }
        return false;
    }

    public function getUpdateSnippetID()
    {
        $snippetID = $_POST['updateSnippetID'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
    }


    public function triedToDeleteSnippet()
    {
        if (isset($_POST['deleteSnippetButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getSnippetID()
    {
        $snippetID = $_POST['snippetID'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
        return false;
    }

    public function triedToGotoCreateView()
    {
        if (isset($_POST['gotoCreateSnippetViewButton'])) {
            return true;
        } else {
            return false;
        }
    }

}
