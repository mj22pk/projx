<?php
require_once dirname(__FILE__) . '/../model/Functions.php';
require_once dirname(__FILE__) . '/simpletest/autorun.php';

/**
* Tests for Functions.php 
*/
class TestOfSnippetValidation extends UnitTestCase {

    function testvalMaxLenght() {

        $f = new Functions();
        $this->assertFalse($f->valMaxLenght("somesting", 6));
        $this->assertTrue($f->valMaxLenght("somesting", 11));
    }
    function testValUrl() {

        $f = new Functions();
        $this->assertFalse($f->valUrl("f.*.com"));
        $this->assertTrue($f->valUrl("http://www.url.com"));
    }
    function testValEmail() {

        $f = new Functions();
        $this->assertFalse($f->valEmail("mail@@mail.com"));
        $this->assertTrue($f->valUrl("mail@mail.com"));
    }
    public function testValidateSnippet() {

        $stripSnippet = new Functions();
        $validSnippet = "<?php\n\tfunction phptag(\$args0) {\n\t\techo \"first\";\n\t}\n?>";
        $validStrippedSnippet = "<?php function phptag(\$args0) {echo \"first\";} ?>";
        $strippedSnippet = $stripSnippet->stripSnippetString($validSnippet);
        $this->assertIdentical($validStrippedSnippet, $strippedSnippet);
        $snippetWithoutPHPTag = "function nophptag(\$args0) {\n\t\techo \"second\";\n\t}";
        $validStrippedSnippet = "function nophptag(\$args0) {echo \"second\";}";
        $strippedSnippet = $stripSnippet->stripSnippetString($snippetWithoutPHPTag);
        $this->assertIdentical($validStrippedSnippet, $strippedSnippet);
    }
}
