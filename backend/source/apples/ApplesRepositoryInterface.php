<?php

namespace backend\source\apples;

interface ApplesRepositoryInterface
{
    public function getAll();

    public function deleteAll();

    public function saveMany($apples);
}