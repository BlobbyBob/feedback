<?php

namespace Models;

use function in_array;
use function is_string;
use function json_encode;
use stdClass;

/**
 * Class Checkbox
 * Represents an <input type="checkbox">
 * @package Feedback
 * @subpackage Models
 * @category ORM
 * @author Ben Swierzy
 */
class Checkbox extends Formelement
{

    const BEFORE = 0;
    const AFTER = 1;

    /**
     * @var string $label The label for the checkbox
     */
    public $label = '';

    /**
     * @var int $label_position Either Checkbox::BEFORE or Checkbox::AFTER
     */
    public $label_position = self::BEFORE;

    /**
     * Checkbox constructor.
     * @param object $data The data for initializing
     */
    public function __construct($data)
    {

        if (isset($data->label) && is_string($data->label))
            $this->label = $data->label;

        if (isset($data->label_position) && in_array($data->label_position, [self::BEFORE, self::AFTER])) {
            $this->label_position = $data->label_position;
        }

    }

    public function get_html()
    {
        // TODO: Implement get_html() method.
    }
    
    /**
     * Returns true, since this element is a checkbox
     * @return bool
     */
    public function is_checkbox()
    {
        return true;
    }

    /**
     * Get the settings of this form element
     * Should be parsed by a view
     *
     * @return array
     */
    public function get_settings()
    {
        $settings = [
            'id' => $this->id,
            'index' => $this->index,
            'type' => "Checkbox",
            'settings' => [
                [
                    'key' => "Beschriftung",
                    'type' => "text",
                    'name' => "label",
                    'value' => $this->label
                ],
                [
                    'key' => "Beschriftungsposition",
                    'type' => "select",
                    'name' => "label_position",
                    'options' => [
                        [
                            'value' => self::BEFORE,
                            'title' => 'Links',
                            'selected' => $this->label_position==self::BEFORE
                        ],
                        [
                            'value' => self::AFTER,
                            'title' => 'Rechts',
                            'selected' => $this->label_position==self::AFTER
                        ]
                    ]
                ]
            ]
        ];
        return $settings;
    }

    /**
     * Return the data of this formelement as object similar to the object by Formelement::create
     *
     * @return object
     */
    public function export()
    {
        $o = new stdClass();
        $o->id = $this->id;
        $o->index = $this->index;

        $j = new stdClass();
        $j->label = $this->label;
        $j->label_position = $this->label_position;
        $o->data = json_encode($j);

        return $o;
    }

    /**
     * Calculate statistics about this object
     *
     * @param array $data The data set saved for this element
     * @return array
     */
    public function stats($data)
    {

        $yes = 0;
        $no = 0;

        foreach ($data as $value) {
            if ($value)
                $yes++;
            else
                $no++;
        }

        $stats = [
            'label' => $this->label,
            'type' => 'options',
            'options' => [
                [
                    'key' => 'yes',
                    'value' => $yes
                ],
                [
                    'key' => 'no',
                    'value' => $no
                ]
            ]
        ];

        return $stats;
    }


}
