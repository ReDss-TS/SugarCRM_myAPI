<?php

class ModelSessions extends CoreModel
{   
   
    protected $msgs = [
        'login'      => 'Login is incorrect',
        'pass'       => 'Password is incorrect',
        'deleted'    => 'Record deleted successfully',
        'notDelete'  => 'Record has not been deleted',
        'busyLogin'  => 'Login is busy! Please enter another login',
        'registered' => 'You have successfully registered',
        'add'        => 'New record created successfully',
        'notAdd'     => 'New record not created',
        'updated'    => 'Record update successfully',
        'notUpdated' => 'New record not updated'
    ];

    public function issetLogin() 
    {
        if (isset($_SESSION['login'])) {
            return true;
        }
        return false;
    }

    public function authenticationToSession($id, $login)
    {
        $_SESSION['userId'] = $id;
        $_SESSION['login'] = $login;
    }

    public function recordMessageInSession($addressMsg, $msg)
    {
        if (is_array($msg)) {
            $_SESSION['message'][$addressMsg] = $this->createMsg($msg);
        } else {
            $_SESSION['message'][$addressMsg] = $msg;
        }
    }

    /**
     * generate msg for user
     * @param string $data With a data for render form such as input data, validated data
     * @return string
     */
    private function createMsg($data)
    {
        $msg = '';
        foreach ($this->msgs as $key => $value) {
            if (isset($data[$key])) {
                if ($data[$key] == true) {
                   $msg .= $value;
                }
            }
        }
        return $msg;
    }

    public function unsetMessages()
    {
        unset($_SESSION['message']);
    }

    public function getUserID()
    {   
        if (isset($_SESSION['userId'])) {
            return $_SESSION['userId'];
        }
    }
}
