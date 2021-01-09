<?php

namespace ZnBundle\Rbac\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class ItemEntity extends Item implements ValidateEntityInterface, EntityIdInterface
{

    protected $id = null;

    //private $name = null;

    //private $type = null;

    //private $description = null;

    //private $ruleName = null;

    //private $data = null;

    //private $createdAt = null;

    //private $updatedAt = null;

    private $children = null;

    public function validationRules()
    {
        return [
            'name' => [
                new Assert\NotBlank,
            ],
            'type' => [
                new Assert\NotBlank,
            ],
            /*'description' => [
                new Assert\NotBlank,
            ],
            'ruleName' => [
                new Assert\NotBlank,
            ],
            'data' => [
                new Assert\NotBlank,
            ],
            'createdAt' => [
                new Assert\NotBlank,
            ],
            'updatedAt' => [
                new Assert\NotBlank,
            ],*/
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setName($value) : void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($value) : void
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDescription($value) : void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setRuleName($value) : void
    {
        $this->ruleName = $value;
    }

    public function getRuleName()
    {
        return $this->ruleName;
    }

    public function setData($value) : void
    {
        $this->data = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    public function setChildren(Collection $children): void
    {
        $this->children = $children;
    }
}

