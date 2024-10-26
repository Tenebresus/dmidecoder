<?php

namespace Tenebresus\Dmidecoder;

class Type {

    private string $_name;
    private string $_description;
    private array $_properties;

    public function __construct(string $name, string $description) {

        $this->_name = $name;
        $this->_description = $description;

    }

    public function addProperty(array $property) : self {

        $key = $property['key'];
        $value = $property['value'];

        $this->_properties[$key] = $value;
        return $this;

    }


}