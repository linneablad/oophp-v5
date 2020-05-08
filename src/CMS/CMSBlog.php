<?php
namespace liba19\CMS;

use liba19\FunctionsTrait\FunctionsTrait;
use liba19\MyTextFilter\MyTextFilter;

/**
 * Class to handle blogposts in database
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class CMSBlog
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
     * Fetch all blogposts
     *
     * @return array  $resultset as the blogposts
     */
    public function fetchAll() : array
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;

        $resultset = $this->db->executeFetchAll($sql, ["post"]);

        $resultset = $this->getUntilMore($resultset);
        $resultset = $this->filter($resultset);

        return $resultset;
    }



    /**
     * Fetch one blogpost and filter its data
     *
     * @param string $route The slug of the requested post
     *
     * @return array  $content as the blogpost
     */
    public function fetchOne($route) : array
    {
        $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
slug = ?
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
ORDER BY published DESC
;
EOD;

        $resultset = $this->db->executeFetch($sql, [$route, "post"]);

        $resultset = $this->filter($resultset);

        $content = [
            "title" => $this->esc($resultset->title),
            "published_iso8601" => $this->esc($resultset->published_iso8601),
            "published" => $this->esc($resultset->published),
            "data" => $resultset->data
        ];

        return $content;
    }



    /**
     * Get text until <!--more--> or all text.
     *
     * @param array $resultset as the blogposts containing the data to show
     *
     * @return array $resultset as the blogposts with the data to be displayed
     */
    public function getUntilMore($resultset) : array
    {
        foreach ($resultset as $value) {
            $pos = stripos($value->data, "<!--more-->");
            if ($pos) {
                $value->data = substr($value->data, 0, $pos);
            }
        }

        return $resultset;
    }
}
