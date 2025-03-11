<?php

namespace App\Interfaces;

interface PoliticaRepositoryInterface 
{
  public function findAll();

  public function findById($data);

  public function create($data);

  public function delete($data);

}