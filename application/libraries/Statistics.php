<?php

use Models\Formelement;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Statistics
 *
 * @package Feedback
 * @subpackage Library
 * @category Evaluation
 * @author Ben Swierzy
 */
class Statistics
{

    /**
     * @var CI_Controller The CI Controller
     */
    protected $CI;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var Statistics_Result
     */
    protected $result;

    /**
     * @var Formelement[]
     */
    protected $elements;

    /**
     * @var string
     */
    protected $view;

    /**
     * Statistics constructor.
     * @param string $view A view for formatting the statistics
     */
    public function __construct($view = 'backend/bootadmin/statistics')
    {
        $this->CI = &get_instance();
        $this->view = $view;
    }

    /**
     * Set the data to calculate statistics about
     * This function resets saved results
     *
     * @param string|array $data The data either as JSON encoded string, an array of associative arrays or an array of objects
     * @throws InvalidArgumentException
     * @return void
     */
    public function set($data)
    {
        if (is_string($data))
            $data = json_decode($data);
        $this->data = $data;
        if (is_null($this->data) || !is_array($this->data)) {
            $this->data = null;
            throw new InvalidArgumentException('Invalid Data: Data is not an (opitonal json encoded) array.');
        }
        $this->result = null;
        $this->elements = null;
    }

    /**
     * Calculate statistics based on the data set
     *
     * @throws RuntimeException
     * @return void
     */
    public function run() {

        if (is_null($this->data)) {
            throw new RuntimeException('There is no data set to calculate statistics on.');
        }

        if (is_null($this->elements)) {
            throw new RuntimeException('The elements have not been set.');
        }

        // Group data by elements
        $dbe = [];
        foreach ($this->data as $dto)
            foreach ($dto as $id => $value)
                $dbe[$id][] = $value;

        $this->result = new Statistics_Result($this->view);

        foreach ($this->elements as $element) {
            $this->result->add($element->stats($dbe[$element->id]));
        }
    }

    /**
     * Get the calculated Statistics
     *
     * @throws RuntimeException
     * @return Statistics_Result
     */
    public function get() {
        if (is_null($this->result)) {
            throw new RuntimeException('No calculation has been performed.');
        }
        return $this->result;
    }

//    /**
//     * Calculate statistics on data
//     *
//     * @param string|array $data The data either as JSON encoded string, an array of associative arrays or an array of objects
//     * @param callable $getElementTypes A function that returns the element type(s) by getting (an array of) id(s)
//     * @throws InvalidArgumentException
//     * @return Statistics_Result
//     */
//    public function fetch($data, $getElementTypes) {
//        $this->set($data);
//        $this->run($getElementTypes);
//        return $this->get();
//    }

    /**
     * Get all element ids out of the data
     *
     * @throws RuntimeException
     * @return array
     */
    public function get_ids()
    {
        $ids = [];
        foreach ($this->data as $dto) {
            foreach ($dto as $id => $value) {
                if ( ! is_numeric($id))
                    throw new RuntimeException('The data has an unexpected format. Expecting numeric keys.');
                if ( ! in_array($id, $ids))
                    $ids[] = $id;
            }
        }

        return $ids;
    }

    /**
     * Set the element types based for all the ids returned by get_ids()
     *
     * @param Formelement[] $elements
     * @see Statistics::get_ids()
     * @return void
     */
    public function set_form_elements($elements)
    {
        $this->elements = $elements;
    }

}

class Statistics_Result extends IteratorIterator
{

    /**
     * @var CI_Controller The CI Controller
     */
    private $CI;

    /**
     * @var string[] Formatted esults
     */
    private $result = [];

    /**
     * @var string
     */
    private $view;

    /**
     * Statistics_Result constructor.
     * @param string $view The view for formatting the results
     */
    public function __construct($view)
    {
        $this->CI = &get_instance();
        $this->view = $view;
        parent::__construct(new ArrayIterator($this->result));
    }

    /**
     * @param array $stats The calculated statistics.
     * @return void
     */
    public function add($stats)
    {
        $result[] = $this->CI->load->view($this->view, $stats, TRUE);
    }
}