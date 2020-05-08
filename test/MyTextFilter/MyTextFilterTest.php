<?php

namespace liba19\MyTextFilter;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class MyTextFilter
 */
class MyTextFilterTest extends TestCase
{

    /**
     * Test that the method parse() filters the text with filter bbcode2html
     */
    public function testParseBbcode()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->parse("[b]Bold text[/b]
        [i]Italic text[/i]
        [u]Underlined text[/u]
        [url=http://dbwebb.se]a link to dbwebb[/url]
        [img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]", ["bbcode"]);

        $exp = '<strong>Bold text</strong>
        <em>Italic text</em>
        <u>Underlined text</u>
        <a href="http://dbwebb.se">a link to dbwebb</a>
        <img src="https://dbwebb.se/image/tema/trad/blad.jpg" />';

        $this->assertEquals($exp, $res);
    }



    /**
     * Test that the method parse() filters the text with 2 filters (bbcode and nl2br)
     */
    public function testParseBbcodeNl2br()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->parse("[b]Bold text[/b]
        [i]Italic text[/i]
        [u]Underlined text[/u]
        [url=http://dbwebb.se]a link to dbwebb[/url]
        [img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]", ["bbcode", "nl2br"]);

        $exp = '<strong>Bold text</strong><br />
        <em>Italic text</em><br />
        <u>Underlined text</u><br />
        <a href="http://dbwebb.se">a link to dbwebb</a><br />
        <img src="https://dbwebb.se/image/tema/trad/blad.jpg" />';

        $this->assertEquals($exp, $res);
    }



    /**
     * Test that the method makeClickable ignores links in existing iframe-tag
     */
    public function testBbcode2html()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->bbcode2html("[b]Bold text[/b]
        [i]Italic text[/i]
        [u]Underlined text[/u]
        [url=http://dbwebb.se]a link to dbwebb[/url]
        [img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]");

        $exp = '<strong>Bold text</strong>
        <em>Italic text</em>
        <u>Underlined text</u>
        <a href="http://dbwebb.se">a link to dbwebb</a>
        <img src="https://dbwebb.se/image/tema/trad/blad.jpg" />';

        $this->assertEquals($exp, $res);
    }



    /**
     * Test method makeClickable with HTTPS
     */
    public function testMakeClickableHTTPS()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->makeClickable("https://dbwebb.se");
        $exp = '<a href="https://dbwebb.se">https://dbwebb.se</a>';
        $this->assertEquals($exp, $res);
    }



    /**
     * Test method makeClickable with HTTP
     */
    public function testMakeClickableHTTP()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->makeClickable("http://dbwebb.se");
        $exp = '<a href="http://dbwebb.se">http://dbwebb.se</a>';
        $this->assertEquals($exp, $res);
    }



    /**
     * Test that the method makeClickable ignores links in existing anchor-tag
     */
    public function testMakeClickableInAnchor()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->makeClickable('<a href="http://sv.wikipedia.org/wiki/Uniform_Resource_Locator">URLs</a>');
        $exp = '<a href="http://sv.wikipedia.org/wiki/Uniform_Resource_Locator">URLs</a>';
        $this->assertEquals($exp, $res);
    }



    /**
     * Test that the method makeClickable ignores links in existing iframe-tag
     */
    public function testMakeClickableInIframe()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->makeClickable('<iframe src="https://www.w3schools.com"></iframe>');
        $exp = '<iframe src="https://www.w3schools.com"></iframe>';
        $this->assertEquals($exp, $res);
    }



    /**
     * Test that the method markdown() filters text to html
     */
    public function testMarkdown()
    {
        $textfilter = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/../../content/textfilter/sample.md");

        $res = $textfilter->markdown($text);

        $exp = '<h1 id="id1">Header level 1</h1>

<p>Here comes a paragraph.</p>

<ul>
<li>Unordered list</li>
<li>Unordered list again</li>
</ul>

<h2 id="id2">Header level 2</h2>

<p>Here comes another paragraph, now intended as blockquote.</p>

<ol>
<li>Ordered list</li>
<li>Ordered list again</li>
</ol>

<blockquote>
  <p>This should be a blockquote.</p>
</blockquote>

<h3 id="id3">Header level 3</h3>

<p>Here will be a table.</p>

<table>
<thead>
<tr>
  <th>Header 1</th>
  <th align="left">Header 2</th>
  <th align="center">Header 3</th>
  <th align="right">Header 4</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Data 1</td>
  <td align="left">Left aligned</td>
  <td align="center">Centered</td>
  <td align="right">Right aligned</td>
</tr>
<tr>
  <td>Data</td>
  <td align="left">Data</td>
  <td align="center">Data</td>
  <td align="right">Data</td>
</tr>
</tbody>
</table>

<p>Here is a paragraph with some <strong>bold</strong> text
and some <em>italic</em> text and a
<a href="http://dbwebb.se">link to dbwebb.se</a>.</p>
';

        $this->assertEquals($exp, $res);
    }



    /**
     * Test method nl2br
     */
    public function testnl2br()
    {
        $textfilter = new MyTextFilter();

        $res = $textfilter->nl2br("\n");
        $exp = "<br />\n";
        $this->assertEquals($exp, $res);
    }
}
