<?php

use Models\Formelement;

/**
 * Class Forms
 * Database interface for fetching the survey form
 * @package Feedback
 * @subpackage Models
 * @category Database
 * @author Ben Swierzy
 */
class Forms extends CI_Model
{
    /**
     * Form constructor.
     */
    public function __construct()
    {
        parent::__construct(); // Only because IDE marks this...
        $this->load->database();
    }

    /**
     * Output all form elements of the latest form
     * @return Formelement[]
     */
    public function get_form()
    {
        /** @var CI_DB_result $query */
        $query = $this->db->query("SELECT * FROM formelements WHERE version=(SELECT MAX(version) FROM formelements) ORDER BY `index` ASC");
        $elements = [];
        foreach ($query->result() as $row) {
            $elements[] = Formelement::create($row);
        }
        return $elements;
    }

    /**
     * Add a formelement to the current form.
     *
     * @param string $type
     * @return Formelement
     */
    public function add_formelement($type)
    {
        $class = Formelement::getFormelementClassName($type);
        $formelement = new $class(new stdClass());
        $obj = $formelement->export();
        $obj->id = null;
        $query = $this->db->query("SELECT MAX(`index`) AS `index`, MAX(`version`) AS `version` FROM formelements WHERE version=(SELECT MAX(version) FROM formelements)");
        $result = $query->result()[0];
        $obj->index = $result->index + 1;
        $obj->version = 0;

        $this->db->insert('formelements', $obj);
        $formelement->id = $this->db->insert_id();
        $formelement->index = $obj->index;

        return $formelement;
    }

    /**
     * Get all Formelements with specific ids
     *
     * @param array $ids An array of Formelement ids
     * @return Formelement[]
     */
    public function get_form_elements($ids)
    {
        $this->db->select('data');
        $this->db->where_in('id', $ids);
        $query = $this->db->get('formelements');
        $elements = [];
        foreach ($query->result() as $row) {
            $elements[] = Formelement::create($row);
        }
        return $elements;
    }

    /**
     * Save updated form elements in persisten storage
     *
     * @param array|object $data The updates to perform
     * @return int Number of updates performed
     */
    public function update($data)
    {
        return $this->db->update_batch('formelements', $data, 'id');
    }

    /**
     * Delete an element from the database
     *
     * @param Formelement $elem Delete this formelement
     * @return int Number of deleted elements
     */
    public function delete($elem)
    {
        $this->db->where('id', $elem->id);
        $this->db->delete('formelements');
        return $this->db->affected_rows();
    }

    /**
     * Delete all formelements, that were added, but not saved
     *
     * @return void
     */
    public function remove_old_elements()
    {
        $this->db->where('version', '0');
        $this->db->delete('formelements');
    }

    /**
     * Get the maximum (=latest) version number
     *
     * @return int
     */
    public function max_version()
    {
        return $this->db->query("SELECT MAX(version) as version FROM formelements")->result()[0]->version;
    }

}
