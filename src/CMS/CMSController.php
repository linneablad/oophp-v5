<?php

namespace liba19\CMS;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;
use liba19\HandleGlobalVariables\HandleGlobalVariablesTrait;
use liba19\FunctionsTrait\FunctionsTrait;

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
class CMSController implements AppInjectableInterface
{
    use AppInjectableTrait;
    use HandleGlobalVariablesTrait;
    use FunctionsTrait;


    private $cmsContent;
    private $cmsPage;
    private $cmsBlog;


    /**
     * Initialize and connect to database
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->app->db->connect();
        $this->cmsContent = new CMSContent($this->app->db);
        $this->cmsPage = new CMSPage($this->app->db);
        $this->cmsBlog = new CMSBlog($this->app->db);
    }



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

        $title = "Content Management System";

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/index");
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Show everything in the database
     *
     * @return object
     */
    public function showAllAction() : object
    {
        $page = $this->app->page;

        $title = "Visa allt i databasen";

        $resultset = $this->cmsContent->fetchAll();

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/show-all", [
            "resultset" => $resultset
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Create
     *
     * @return object
     */
    public function createAction() : object
    {
        $page = $this->app->page;

        $title = "Skapa nytt";

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/create");
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Create - create new post/page
     *
     * @return object
     */
    public function createActionPost()
    {
        $response = $this->app->response;

        if ($this->getPost("doCreate")) {
            $title = $this->getPost("contentTitle");

            $this->cmsContent->createContent($title);
            $contentId = $this->cmsContent->getLast();

            return $response->redirect("cms/edit?contentId=$contentId");
        }

        return $response->redirect("cms/index");
    }



    /**
     * Edit
     *
     * @return object
     */
    public function editAction() : object
    {
        $page = $this->app->page;
        $response = $this->app->response;

        $title = "Redigera";

        $contentId = $this->getGet("contentId");

        if (!is_numeric($contentId)) {
            return $response->redirect("cms/show-all");
        }

        $content = $this->cmsContent->fetchOne($contentId);

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/edit", [
            "id" => $this->esc($content->id),
            "title" => $this->esc($content->title),
            "path" => $this->esc($content->path),
            "slug" => $this->esc($content->slug),
            "data" => $this->esc($content->data),
            "type" => $this->esc($content->type),
            "filter" => $this->esc($content->filter),
            "published" => $this->esc($content->published)
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Edit - save details
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $response = $this->app->response;

        $contentId = $this->getPost("contentId") ?: $this->getGet("contentId");

        if (!is_numeric($contentId)) {
            return $response->redirect("cms/index");
        }

        if ($this->getPost("doDelete")) {
            return $response->redirect("cms/delete?contentId=$contentId");
        } elseif ($this->getPost("doSave")) {
            $params = $this->getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);
        }

        $this->cmsContent->updateContent($params);

        return $response->redirect("cms/edit?contentId=$contentId");
    }



    /**
     * Delete page/post
     *
     * @return object
     */
    public function deleteAction() : object
    {
        $page = $this->app->page;
        $response = $this->app->response;

        $title = "Radera";

        $contentId = $this->getPost("contentId") ?: $this->getGet("contentId");

        if (!is_numeric($contentId)) {
            return $response->redirect("cms/index");
        }

        $content = $this->cmsContent->fetchOne($contentId);

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/delete", [
            "id" => $this->esc($content->id),
            "title" => $this->esc($content->title)
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Delete - mark as deleted
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        $response = $this->app->response;

        $contentId = $this->getPost("contentId") ?: $this->getGet("contentId");

        if (!is_numeric($contentId)) {
            return $response->redirect("cms/index");
        }

        if ($this->getPost("doDelete")) {
            $this->cmsContent->deleteContent($contentId);
        }

        return $response->redirect("cms/admin");
    }



    /**
     * Admin page to update and delete
     *
     * @return object
     */
    public function adminAction() : object
    {
        $page = $this->app->page;

        $title = "Admin";

        $resultset = $this->cmsContent->fetchAll();

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/admin", [
            "resultset" => $resultset
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Show pages
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $page = $this->app->page;

        $title = "Visa sidor";

        $resultset = $this->cmsPage->fetchAll();

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/pages", [
            "resultset" => $resultset
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Show a page
     *
     * @param string $route The path to the requested page
     *
     * @return object
     */
    public function pageActionGet($route) : object
    {
        $page = $this->app->page;
        $response = $this->app->response;

        $content = $this->cmsPage->fetchOne($route);

        if (!$content) {
            return $response->redirect("cms/notFound");
        }

        $title = $content["title"];

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/page", [
            "title" => $content["title"],
            "modified_iso8601" => $content["modified_iso8601"],
            "modified" => $content["modified"],
            "data" => $content["data"]
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Show all blogposts
     *
     * @return object
     */
    public function blogAction() : object
    {
        $page = $this->app->page;

        $title = "Visa blogg";

        $resultset = $this->cmsBlog->fetchAll();

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/blog", [
            "resultset" => $resultset
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Show a blogpost
     *
     * @param string $route The slug of the requested post
     *
     * @return object
     */
    public function blogpostActionGet($route) : object
    {
        $page = $this->app->page;
        $response = $this->app->response;

        $content = $this->cmsBlog->fetchOne($route);

        if (!$content) {
            return $response->redirect("cms/notFound");
        }

        $title = $content["title"];

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/blogpost", [
            "title" => $content["title"],
            "published_iso8601" => $content["published_iso8601"],
            "published" => $content["published"],
            "data" => $content["data"]
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Reset database
     *
     * @return object
     */
    public function resetAction() : object
    {
        $page = $this->app->page;

        $title = "Återskapa databasen";

        $resetSuccess = $this->getGet("resetSuccess") ?? null;

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/reset", [
            "resetSuccess" => $resetSuccess
        ]);
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Reset database - do reset
     *
     * @return object
     */
    public function resetActionPost()
    {
        $response = $this->app->response;

        if ($this->getPost("doReset")) {
            $this->cmsContent->resetContent();

            return $response->redirect("cms/reset?resetSuccess=true");
        }
        return $response->redirect("cms/reset");
    }




    /**
     * 404 page not found
     *
     * @return object
     */
    public function notFoundAction() : object
    {
        $page = $this->app->page;

        $title = "404 Not found";

        $page->add("cms/sidebar");
        $page->add("cms/article-header");
        $page->add("cms/404");
        $page->add("cms/article-footer");

        return $page->render([
            "title" => $title,
        ]);
    }
}
