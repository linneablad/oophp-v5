<?php
namespace liba19\CMS;

use liba19\FunctionsTrait\FunctionsTrait;

/**
 * General class to handle blogposts and pages in database
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class CMSContent
{
    use FunctionsTrait;


    /**
     * @var Anax\Database $db Database connection
     */
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }



    /**
     * Fetch everything in table content
     *
     * @return array  $resultset containing the posts/pages
     */
    public function fetchAll() : array
    {
        $sql = "SELECT * FROM content;";
        $resultset = $this->db->executeFetchAll($sql);

        return $resultset;
    }



    /**
     * Create new post/page
     *
     * @param string $title The value to be inserted
     *
     * @return void
     */
    public function createContent($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
    }



    /**
     * Get last id
     *
     * @return int as last inserted id
     */
    public function getLast() : int
    {
        return $this->db->lastInsertId();
    }



    /**
     * Fetch one row in table content
     *
     * @param int $id The row to be fetched
     *
     * @return object  $content as the page/post
     */
    public function fetchOne($id) : object
    {
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $this->db->executeFetch($sql, [$id]);

        return $content;
    }



    /**
     * Update a post/page
     *
     * @param array $params The values to be updated
     *
     * @return void
     */
    public function updateContent($params)
    {
        if (!$params["contentSlug"]) {
            $params["contentSlug"] = $this->slugify($params["contentTitle"]);
        }
        $params["contentSlug"] = $this->checkSlug($params);

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $this->db->execute($sql, array_values($params));
    }



    /**
     * Check if slug is unique
     *
     * @param array $params The values to be checked
     *
     * @return string $params["contentSlug"] as the slug
     */
    public function checkSlug($params) : string
    {
        $sql = "SELECT slug, id FROM content WHERE slug = ? AND id <> ?;";
        $slugIsNotUnique = $this->db->executeFetch($sql, [$params["contentSlug"], $params["contentId"]]);

        if ($slugIsNotUnique) {
            $params["contentSlug"] .= $params["contentId"];
        }

        return $params["contentSlug"];
    }



    /**
     * Mark as deleted
     *
     * @param int $contentId The row to be deleted
     *
     * @return void
     */
    public function deleteContent($contentId)
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->db->execute($sql, [$contentId]);
    }



    /**
     * Reset database
     *
     * @return void
     */
    public function resetContent()
    {
        $text = file_get_contents(__DIR__ . "/../../sql/cms/reset.sql");
        $sql = explode(";", $text);
        array_pop($sql);

        foreach ($sql as $value) {
            $value .= ";";
            $this->db->execute($value);
        }
    }
}
