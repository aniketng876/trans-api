<?php
namespace App\BO;

class CategoryBO
{
    public string $name;
    public ?int $parent_category_id;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->parent_category_id = isset($data['parent_category_id']) ? (int) $data['parent_category_id'] : null;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent_category_id' => $this->parent_category_id,
        ];
    }
}
