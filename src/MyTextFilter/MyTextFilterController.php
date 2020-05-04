<?php

namespace liba19\MyTextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MyTextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    //private $db = "not active";



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->app->page;

        $title = "Test av textfilter";

        $page->add("textfilter/sidebar");
        $page->add("textfilter/article-header");
        $page->add("textfilter/index");
        $page->add("textfilter/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * BBCode to HTML
     *
     * @return object
     */
    public function bbcode2htmlAction() : object
    {
        $page = $this->app->page;

        $title = "BBCode till HTML";

        $text = file_get_contents(__DIR__ . "/../../content/textfilter/bbcode.txt");
        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["bbcode", "nl2br"]);

        $page->add("textfilter/sidebar");
        $page->add("textfilter/article-header");
        $page->add("textfilter/bbcode2html", [
            "text" => $text,
            "html" => $html
        ]);
        $page->add("textfilter/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Make links clickable
     *
     * @return object
     */
    public function makeClickableAction() : object
    {
        $page = $this->app->page;

        $title = "Gör länkar klickbara";

        $text = file_get_contents(__DIR__ . "/../../content/textfilter/clickable.txt");
        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["link"]);

        $page->add("textfilter/sidebar");
        $page->add("textfilter/article-header");
        $page->add("textfilter/make-clickable", [
            "text" => $text,
            "html" => $html
        ]);
        $page->add("textfilter/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Markdown to HTML
     *
     * @return object
     */
    public function markdownAction() : object
    {
        $page = $this->app->page;

        $title = "Från markdown till HTML";

        $text = file_get_contents(__DIR__ . "/../../content/textfilter/sample.md");
        $filter = new MyTextFilter();
        $html = $filter->parse($text, ["markdown"]);

        $page->add("textfilter/sidebar");
        $page->add("textfilter/article-header");
        $page->add("textfilter/markdown", [
            "text" => $text,
            "html" => $html
        ]);
        $page->add("textfilter/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }
}
