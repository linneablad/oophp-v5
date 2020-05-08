<?php
namespace liba19\FunctionsTrait;

use liba19\MyTextFilter\MyTextFilter;

/**
 * Trait for useful functions
 */
trait FunctionsTrait
{
    /**
     * Sanitize value for output in view.
     *
     * @param string $value to sanitize
     *
     * @return string beeing sanitized
     */
    public function esc($value) : string
    {
        return htmlentities($value);
    }



    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return string $str the formatted slug.
     */
    public function slugify($str) : string
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }



    /**
     * Filter text
     *
     * @param mixed $resultset The resultset containing the filters to use
     * and the data to be filtered
     *
     * @return mixed  $resultset As the resultset now filtered
     */
    public function filter($resultset)
    {
        $textfilter = new MyTextFilter();

        if (is_array($resultset)) {
            foreach ($resultset as $value) {
                $filterArr = explode(",", $value->filter);
                $value->data = $textfilter->parse($value->data, $filterArr);
            }
        } else {
            $filterArr = explode(",", $resultset->filter);
            $resultset->data = $textfilter->parse($resultset->data, $filterArr);
        }

        return $resultset;
    }
}
