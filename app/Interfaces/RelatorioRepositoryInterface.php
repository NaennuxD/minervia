<?php

namespace App\Interfaces;

interface RelatorioRepositoryInterface 
{
  public function findAll();

  public function findById($data);

  public function create($data);

  public function configure($data);

  public function delete($data);

}
