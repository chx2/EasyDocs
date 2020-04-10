<?php
/*
  Easy Docs by Chris H.

  Sorter Class
  Used to handle resorting/bundling of section items
*/

namespace chx2;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Sorter
 * @package chx2
 */
class Sorter
{

    public $list;
    public $sorted;

    private $key;

    /**
     * Sorter constructor.
     * @param $list
     */
    public function __construct($list)
    {
        $this->list = $list;
        $this->sorted = $this->escapeWalk();
        $this->key = key($this->sorted);
    }

    /**
     * Sort document list
     */
    public function sort()
    {
        if (isset($this->sorted['sortable'])) {
            $sections = array();
            foreach ($this->sorted['sortable'] as $key => $value) {
                $sections[$value] = $this->list['pages'][$value];
            }
            $this->list['pages'] = $sections;
            echo json_encode($this->list['pages'], true);
        } else {
            $this->list['pages'][$this->key] = $this->sorted[$this->key];
            echo 'Document order has been updated!';
        }
        $yaml = Yaml::dump($this->list, 2);
        file_put_contents(CONFIG_URI, $yaml);
    }

    /**
     * Escape POST array recursively
     * @return mixed
     */
    private function escapeWalk()
    {
        foreach ($_POST as $item) {
            if (is_array($item)) {
                foreach ($item as $value) {
                    htmlspecialchars($value);
                }
            } else {
                htmlspecialchars($item);
            }
        }
        return $_POST;
    }

}
