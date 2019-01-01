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

    /**
     * @var int Policy. Default action when no rules can be applied
     */
    protected $policy;

    /**
     * @var Rule[] Rules, that define an access scheme
     */
    protected $rules;

    /**
     * @var bool True in case logging in wasn't successful
     */
    private $error = false;

    private const DENY = 0;
    private const ACCEPT = 1;

    public function __construct()
    {

        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');

        if (is_cli() || (defined('ENVIRONMENT') && ENVIRONMENT == 'testing')) {
            $this->logged_in = true;
            return;
        }

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

        if ( ! is_null($this->CI->input->get('logout'))) {
            $this->logout();
        }

        // Check if login form got submitted
        if ( ! is_null($this->CI->input->post('login'))) {
            // Try login
            if ( ! is_null($this->CI->input->post('username')) && ! is_null($this->CI->input->post('password'))) {
                $username = $this->CI->input->post('username');
                $password = $this->CI->input->post('password');
                if ( ! $this->login($username, $password)) {
                    $this->error = true;
                }
            }
        }

        $this->loadConfig();

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
            if (hash_equals(crypt($password, $salt), $user->getPassword())) {
                $this->logged_in = true;
                $this->user = $user;
                $this->CI->session->user_id = $user->id;
                $this->CI->session->logged_in = true;
                return true;
            } else {
                return false;
            }
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

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->logged_in;
    }

    private function loadConfig()
    {
        $this->CI->config->load('auth');
        $this->policy = $this->CI->config->item('policy', 'auth');
        foreach ($this->CI->config->item('rules', 'auth') as $controller => $r) {
            foreach ($r as $method => $target)
                $this->addRule($controller, $method, $target);
        }
    }

    /**
     * @param string $controller Controller name
     * @param string $method Method name. Default: Wildcard
     * @param string|int|null $target Either 'accept' (1) ,'deny' (0) or null for the inverse of the policy
     */
    public function addRule($controller, $method = '*', $target = null)
    {
        if (is_null($target))
            $target = 1 - $this->policy;
        if (is_string($target)) {
            switch ($target) {
                case 'accept':
                    $target = self::ACCEPT;
                    break;
                case 'deny':
                    $target = self::DENY;
                    break;
                default:
                    throw new RuntimeException("Invalid target '$target' for authentication rule");
            }
        }

        $rule = new Rule($controller, $method, $target%2);
        $this->rules[] = $rule;

    }

    /**
     * @param string $controller
     * @param string $method
     * @return bool
     */
    public function canAccess($controller, $method)
    {
        // Todo: Extend authentication and access right management. @see https://github.com/BlobbyBob/feedback/issues/11
        return $this->isLoggedIn();
//        if ($this->isLoggedIn())
//            return true;
//        $access = $this->policy;
//        foreach ($this->rules as $rule) {
//            if ($rule->matches($controller, $method))
//                $access = $rule->target;
//        }
//        return $access == self::ACCEPT;
    }

    /**
     * Usually called by a Controller, when the user wants to access a method
     * @param $controller
     * @param $method
     * @return bool
     */
    public function pageAccess($controller, $method)
    {
        if ( ! $this->canAccess($controller, $method)) {
            $this->displayLogin();
            return false;
        } else {
            return true;
        }
    }

    private function displayLogin()
    {

        $this->CI->load->helper(['url', 'form']);

        $data = [
            'title' => 'Login',
            'style' => '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . "\">\n"
                . '<link rel="stylesheet" href="' . base_url('resources/css/login.css') . "\">\n",
            'script' => "<script src='" . base_url('resources/js/design.js') . "'></script>\n",
            'error' => $this->error
        ];

        // A little hacky
        echo $this->CI->load->view('templates/header', $data, true);
        echo $this->CI->load->view('backend/login', $data, true);
        echo $this->CI->load->view('templates/footer', $data, true);

    }

    /**
     * Get the user, that is currently logged in
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Log out the current user
     *
     * @return void
     */
    private function logout()
    {
        $this->logged_in = false;
        $this->user = false;
        $this->CI->session->user_id = null;
        $this->CI->session->logged_in = false;
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
        $this->password = crypt($password, $crypt);
    }



}

/**
 * Class Rule
 * Encapsulates an authentication rule
 *
 * @package Feedback
 * @subpackage Library
 * @category Authentication
 * @author Ben Swierzy
 */
class Rule {

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $method;

    /**
     * @var int
     */
    public $target;

    /**
     * Rule constructor.
     * @param $controller
     * @param $method
     * @param $target
     */
    public function __construct($controller, $method, $target)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->target = $target;
    }

    /**
     * @param $controller
     * @param $method
     * @return bool
     */
    public function matches($controller, $method)
    {
        return $this->controller == $controller && ($this->method == '*' || $this->method == $method);
    }

}

class NotLoggedInException extends Exception {}