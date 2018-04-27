<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Phalcon\Mvc\Controller;

/**
 * Description of LogoutController
 *
 * @author dexmo
 */
class LogoutController extends Controller{
    //put your code here
    public function indexAction()
    {
        $this->session->destroy();
        echo "logout succesful!";
    }
}
