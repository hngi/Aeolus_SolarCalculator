<?php

require_once 'helper.php';

class User
{

    var $code,
        $reason,
        $status,
        $message,
        $response;

    protected $db,
              $data;

    public function __construct(int $action = 1)
    {
        // hook in database
        // global $db;
        require_once __DIR__ . '/config.php';
        
        $this->db = $GLOBALS['db'];

        $this->data = $this->get_posted_data();

    }

    protected function format_response_message
    (
        string $message,
        bool $status,
        int $code,
        $reason
    ) {

        return json_encode(
            $response = [
                'message' => $message,
                'status' => $status,
                'code' => $code,
                'reason' => $reason
            ]
        );
    }

    protected function get_posted_data()
    {
        if (empty($_POST)) {

            return false;
        }

        return json_decode(
            file_get_contents("php://input"), true) ? (
                json_decode(
                    file_get_contents(
                        "php://input"
                    ), true))
            : $_POST;
    }

    protected function fields_okay()
    {
        if ($this->data) {

            if (is_json($this->data)) {
                $this->data = json_decode($this->data, true);
            }

            // Make sure the submitted registration values are not empty.
            if (empty($this->data['name']) || empty($this->data['email']) ||
                empty($this->data['password']) || empty($this->data['password_confirmation'])
            ) {
                // One or more values are empty.
                // give a proper error message for easy debugging
                if ( empty($this->data['name']) ) {
                    print $this->format_response_message('empty name or username field', 0, 101, 'empty');
                    return false;
                }
                if ( empty($this->data['email']) ) {
                    print $this->format_response_message('empty email field', 0, 102, 'empty');
                    return false;
                }
                if ( empty($this->data['password']) ) {
                    print $this->format_response_message('empty password field', 0, 103, 'empty');
                    return false;
                }
                if ( empty($data['password_confirmation']) ) {
                    // print $this->format_response_message('empty password confirmation field', 0, 104, 'empty');
                    // return false;
                }
            }

            return true;
        } else {

            print $this->format_response_message('no data sent', 0, 80, '');
            return false;
        }

    }
    
    public function confirm_password($password = 100, $confirm_password = 10)
    {
        $password = $this->data['password'] ? $this->data['password'] : $password;
        $confirm_password = $this->data['password_confirmation'] ? 
                            $this->data['password_confirmation'] : $confirm_password;

        if ($password != $confirm_password) {

            return $this->format_response_message('password does not match', 0, 105, 'not specified');
        }

        return $this->format_response_message('password matches', 1, 106, 0);
    }

    public function is_username_exists($username = null)
    {
        $email = $this->data['name'] ? $this->data['name'] : $username;

        if ($stmt = $this->db->prepare('SELECT id FROM users WHERE name = ?')) {
            $stmt->bind_param('s', $username);
            
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

                return $this->format_response_message('username exists', 1, 107, null);

            } else {

                return $this->format_response_message('no user found', 0, 108, 'not specified');
            }
        } else {
            
            return $this->format_response_message('database misconfiguration', '', 500, 'not specified');
        }

        $this->db->close();
        $this->db = null;

        return $this->format_response_message('no valid response from server', '', 300, 'not specified');
    }

    public function is_email_exists($email)
    {
        $email = $this->data['email'] ? $this->data['email'] : $email;

        if ($stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?')) {
            $stmt->bind_param('s', $email);
            
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

                return $this->format_response_message('email address exists', 1, 109, null);

            } else {

                return $this->format_response_message('email address no exists', 0, 110, null);
            }

            return false;
        
        }else {

            return $this->format_response_message('database misconfiguration', '', 500, null);
        }

        return $this->format_response_message('no valid response from server', '', 300, null);
    }

    public function grant_access($email = null, $paswd = null)
    {
        if (is_null($email)) {
            $email = $this->data['email'] ? $this->data['email'] : $email;
        }
        else {
            $email = $email;
        }

        if (is_null($paswd)) {
            $paswd = $this->data['password'] ? $this->data['password'] : $paswd;
        }
        else {
            $paswd = $paswd;
        }

        $mail_exists = json_decode($this->is_email_exists($email));

        if($mail_exists->status != 0)
        {
            if ($stmt = $this->db->prepare('SELECT id, name, password FROM users WHERE email = ?'))
            {
                $stmt->bind_param('s', $email);

                $stmt->execute();

                // Store the result so we can check if the account exists in the database.
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $name, $password);

                    $stmt->fetch();

                    // Account exists, now we verify the password.
                    if (password_verify($paswd, $password)) {
                        //if password matches log in users using session
                        // if session is satrted, re-generate
                        if (session_status() == PHP_SESSION_ACTIVE) {
                            session_regenerate_id();

                            $_SESSION['loggedin'] = TRUE;
                            $_SESSION['name'] = $name;
                            $_SESSION['email'] = $email;
                            $_SESSION['id'] = $id;

                            return json_encode([
                                'message' => 'Login successful',
                                'status' => true,
                                'user' => $_SESSION['name'],
                                'u_id' => $_SESSION['id'],
                            ]);
                        } else {

                            return $this->format_response_message('Login successful, cannot establish a session', 1, 124, null);
                        }
                    } else {
                        header("Content-Type: application/json; charset=UTF-8");

                        // return $this->format_response_message('Login not successful', 0, 125, 'Incorrect password');
                        return $this->format_response_message('Login not successful', 0, 125, null);
                    }
                } else {
                    return $this->format_response_message('Login not successful', 0, 125, 'Incorrect email');
                }

                $stmt->close();

                return json_encode(array_merge($user, $response));
            
            } else {

                return $this->format_response_message('database misconfiguration', 0, 500, null);
            }
        } else {

            // return $this->format_response_message('email address no exists', 0, 110, null);
            return $this->format_response_message('Login not successful', 0, 110, null);
        }

    }

    public function add_new_user($user_i = null)
    {
        // var_dump($user_i);
        $user = $this->data ? $this->data : $user_i;

        // check if there is a json data
        is_json($user) ? extract(json_decode($user, true)) : (is_array($user) ? extract($user) : print $this->format_response_message('wrong data type', 0, 10, 'array or json is expected'));

        // constructs data array
        $this->data = $user_i;
        // echo(json_encode($this->data));

        if ($this->fields_okay())
        {
            $mail_exists = json_decode($this->is_email_exists($email));
            // $user_exists = json_decode($this->is_username_exists($name));
            // $pawd_okay   = json_decode($this->confirm_password($password, $password_confirmation));

            if($mail_exists->status != 1)
            {
                if ($stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)'))
                {
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt->bind_param('sss', $name, $email, $password);

                    $stmt->execute();

                    $stmt->close();

                    $user = [
                        'name' => $name,
                        'email' => $email,
                        'password' => '**********'
                    ];

                    $response = json_decode(
                        $this->format_response_message('registered successfully', 1, 111, null), true
                    );

                    return json_encode(array_merge($user, $response));
                
                } else {

                    return $this->format_response_message('database misconfiguration', 0, 500, null);
                }
            } else {

                return $this->format_response_message('email address exists', 0, 31, null);
            }
        } else {
            return;
        }

        return $this->format_response_message('no valid response from server', '', 300, null);
    }

}


