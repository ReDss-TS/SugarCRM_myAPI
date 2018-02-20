<?php

class ControllerComponentAuth
{
    public function isAuth()
    {
        $signIn = new ModelSessions;
        $isSignIn = $signIn->issetLogin();
        return $isSignIn;
    }
}
