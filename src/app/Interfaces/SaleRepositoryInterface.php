<?php

namespace App\Interfaces;

interface SaleRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $new);
    public function update($id, array $new);
    public function delete($id);
}
