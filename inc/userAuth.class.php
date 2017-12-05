<?php

class UserAuth
{
  private $users = [
    'Tony' => ['id' => 21, 'name' => 'Tony', 'password' => 'heslo1', 'role' => ['user', 'admin']],
    'Nina' => ['id' => 41, 'name' => 'Nina', 'password' => 'kocka', 'role' => ['user']],
    'Lenka' => ['id' => 65, 'name' => 'Lenka', 'password' => 'heslo1', 'role' => ['user']],
  ];

  public function getIdentity($name)
  {
    $identity = $this->users[$name];
    unset($identity['password']);
    return $identity;
  }

  public function login($name, $password)
  {
    if (isset($this->users[$name]) && $this->users[$name]['password'] == $password)
    {
      return $this->getIdentity($name);
    }
    else
    {
      return false;
    }
  }
}