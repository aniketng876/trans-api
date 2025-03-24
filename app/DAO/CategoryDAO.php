<?php

namespace App\DAO;

class CategoryDAO
{
    public int $id;
    public string $name;
    public int $parent_category_id;

    public function __construct(int $id, string $name,  int $parent_category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent_category_id = $parent_category_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentCategoryId(): int
    {
        return $this->parent_category_id;
    }
}
