<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Authentication
 *
 * @package Feedback
 * @subpackage Library
 * @category Authentication
 * @author Ben Swierzy
 */
class Authentication
{

    /**
     * @var CI_Controller
     */
    protected $CI;

    /**
     * @var bool
     */
    protected $logged_in;

    /**
     * @var User The user that is currently logged in
     */
    protected $user;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();

        // Get Login status
        if ( ! isset($this->CI->session->logged_in) || ! isset($this->CI->session->user_id)) {
            $this->CI->session->logged_in = false;
        }
        $this->logged_in = $this->CI->session->logged_in;
        if ($this->logged_in) {
            try {
                $this->user = new User($this->CI, $this->CI->session->user_id);
            } catch (InvalidArgumentException $e) {
                $this->logged_in = false;
                $this->CI->session->user_id = null;
                $this->CI->session->logged_in = false;
            }
        }

        // Check if login form got submitted
    }

    /**
     * Try to log in with user credentials
     *
     * @param string $username
     * @param string $password
     * @return bool Login successful?
     */
    public function login($username, $password)
    {
        $user = new User($this->CI);
        if ($user->by_name($username)) {
            $delim_pos = strrpos($user->getPassword(), '$');
            $salt = substr($user->getPassword(), 0, $delim_pos);
            return hash_equals(crypt($password, $salt), $user->getPassword());
        } else
            return false;
    }

    /**
     * Register a new user
     * Since this function can return false and 0 you should always compare with the Identity operator '==='
     *
     * @param string $username
     * @param string $password
     * @return int|bool ID of the new user or false, in case an error occurred.
     */
    public function register($username, $password)
    {
        $user = new User($this->CI);
        $user->name = $username;
        $user->setPassword($password);
        if ($user->save())
            return $user->id;
        else
            return false;
    }
}

/**
 * Class User
 * This class is just an ORM for rows from the user table
 *
 * @package Feedback
 * @subpackage Library
 * @category Authentication
 * @author Ben Swierzy
 */
class User {

    /**
     * @var CI_Controller
     */
    protected $CI;

    /**
     * @var int User ID
     */
    public $id;

    /**
     * @var string User name
     */
    public $name;

    /**
     * @var string Hashed user password
     */
    private $password;

    /**
     * User constructor.
     * @param CI_Controller $CI Code Igniter Controller
     * @param int|null $id ID of this user (optional)
     * @throws InvalidArgumentException In case the ID is invalid
     */
    public function __construct(&$CI, $id = null)
    {
        $this->CI = $CI;
        $this->CI->load->database();

        // Get user with $id
        if ( ! is_null($id)) {
            $this->CI->db->where('id', $id);
            $result = $this->CI->db->get('user')->result();
            if (count($result) == 0)
                throw new InvalidArgumentException("Didn't found a user with ID $id");
            $this->id = $result[0]->id;
            $this->name = $result[0]->name;
            $this->password = $result[0]->password;
        }

    }

    /**
     * Get a user object from the username
     *
     * @param string $name Username
     * @return bool True, when a User with the name could be fetch
     */
    public function by_name($name)
    {
        $this->CI->db->where('name', $name);
        $query = $this->CI->db->get('user');
        if ( ! $query->num_rows())
            return false;
        $user = $query->result()[0];
        $this->id = $user->id;
        $this->name = $user->name;
        $this->password = $user->password;
        return true;
    }

    /**
     * Save this user in persistent storage
     * If the @see $id is null, then a new user will be added. Otherwise the existing user will be updated.
     * When a new user is added, the ID of the new user will be written to @see $id
     *
     * @return bool Success of this operation
     */
    public function save()
    {
        if (is_null($this->id)) {

            $data = [
                'name' => $this->name,
                'password' => $this->password
            ];
            $this->CI->db->insert('user', $data);
            $this->id = $this->CI->db->insert_id();
            return (bool) $this->CI->db->affected_rows();

        } else {

            $data = [
                'name' => $this->name,
                'password' => $this->password
            ];
            $this->CI->db->where('id', $this->id);
            $this->CI->db->update('user', $data);
            return (bool) $this->CI->db->affected_rows();

        }
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        // Hash password
        $salt = base64_encode(openssl_random_pseudo_bytes(12));
        $crypt = '$6$rounds=1024$' . $salt;
        $this->password = $password;
    }



}