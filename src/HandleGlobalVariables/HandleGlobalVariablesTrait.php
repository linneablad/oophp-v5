<?php
namespace liba19\HandleGlobalVariables;

/**
 * Trait to handle incoming global variables
 */
trait HandleGlobalVariablesTrait
{
    /**
     * Get value from GET variable or return default value.
     *
     * @param string $key     to look for
     * @param mixed  $default value to set if key does not exists
     *
     * @return mixed value from GET or the default value
     */
    private function getGet($key, $default = null)
    {
        return isset($_GET[$key])
            ? $_GET[$key]
            : $default;
    }



    /**
     * Get value from POST variable or return default value.
     *
     * @param string $key     to look for
     * @param mixed  $default value to set if key does not exists
     *
     * @return mixed value from POST or the default value
     */
    private function getPost($key, $default = null)
    {
        return isset($_POST[$key])
            ? $_POST[$key]
            : $default;
    }



    /**
     * Get value from SESSION variable or return default value.
     *
     * @param string $key     to look for
     * @param mixed  $default value to set if key does not exists
     *
     * @return mixed value from SESSION or the default value
     */
    private function getSession($key, $default = null)
    {
        return isset($_SESSION[$key])
            ? $_SESSION[$key]
            : $default;
    }
}
