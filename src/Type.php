<?php

namespace Tenebresus\Dmidecoder;

class Type {

    private string $_name;
    private string $_description;
    private array $_properties = [];

    public function __construct(string $name, string $description, array $properties) {

        $this->_name = $name;
        $this->_description = $description;
        $this->_properties = $properties;

    }

    public function getName() : string {
        return $this->_name;
    }

    public function getDescription() : string {
        return $this->_description;
    }

    public function getAllPropertyNames() : array {
        return array_keys($this->_properties);
    }

    public function getAllPropertyValues() : array {
        return array_values($this->_properties);
    }

    public function getProperty(string $property) : ?string {
        return $this->_properties[$property] ?? NULL;
    }

}