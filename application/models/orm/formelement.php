<?php

namespace Models;

abstract class FormElement {

    private $type;

    public $name;

    public $id;

    public $page;

    abstract public function get_html();

    public function is_text() {
        return $this->type == 'text';
    }

    public function is_textarea() {
        return $this->type == 'textarea';
    }

    public function is_select() {
        return $this->type == 'select';
    }

    public function is_checkbox() {
        return $this->type == 'checkbox';
    }

    public function is_radio() {
        return $this->type == 'radio';
    }

    public function is_num() {
        return $this->type == 'text';
    }

    /**
     * @param array $data Data of the form element
     * @return FormElement The instantiated subclass
     */
    public static function create($data)
    {

    }

}
