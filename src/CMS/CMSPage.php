<?php
namespace liba19\CMS;

use liba19\FunctionsTrait\FunctionsTrait;

/**
 * Class to handle pages in database
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class CMSPage
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
     * Fetch all pages
     *
     * @return array  $resultset as the pages
     */
    public function fetchAll() : array
    {
        $sql = <<<EOD
SELECT
*,
CASE
    WHEN (deleted <= NOW()) THEN "isDeleted"
    WHEN (published <= NOW()) THEN "isPublished"
    ELSE "notPublished"
END AS status
FROM content
WHERE type=?
;
EOD;
        $resultset = $this->db->executeFetchAll($sql, ["page"]);

        return $resultset;
    }



    /**
     * Fetch one page and filter its data
     *
     * @param string $route The path to the requested page
     *
     * @return array  $content as the page
     */
    public function fetchOne($route) : array
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;

        $resultset = $this->db->executeFetch($sql, [$route, "page"]);

        $resultset = $this->filter($resultset);

        $content = [
            "title" => $this->esc($resultset->title),
            "modified_iso8601" => $this->esc($resultset->modified_iso8601),
            "modified" => $this->esc($resultset->modified),
            "data" => $resultset->data
        ];

        return $content;
    }
}
