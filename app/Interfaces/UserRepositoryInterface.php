<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
  public function findAll();
  
  public function findAllByFuncao($data);

  public function findById($data);

  public function create($data);

  public function update($data);

  public function delete($data);

  public function updatePassword($data);

}
