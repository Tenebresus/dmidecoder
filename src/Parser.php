<?php

namespace Tenebresus\Dmidecoder;


class Parser {

    private string $_dmidecodeOutput;

    /**
     * @var Type[]
     */
    private array $_types = [];
    private const array _TYPE_MAPPING = [

        1 => 'system',
        12 => 'system',
        15 => 'system',
        23 => 'system',
        32 => 'system',
        2 => 'baseboard',
        10 => 'baseboard',
        41 => 'baseboard',
        3 => 'chassis',
        4 => 'processor',
        5 => 'memory',
        6 => 'memory',
        16 => 'memory',
        17 => 'memory',
        7 => 'cache',
        8 => 'cache',
        9 => 'slot'

    ];

    public function __construct(string $dmidecodeOutput) {

        $this->_dmidecodeOutput = $dmidecodeOutput;
        $this->_parse();

    }

    /**
     * @return Type[]
     */
    public function getTypes() : array {
        return $this->_types;
    }

    public function getTypeNames() : array {

        $return = [];

        foreach ($this->_types as $type) {
            $return[] = $type->getName();
        }

        return $return;

    }

    /**
     * @param string $name
     * @return Type[]|null
     */
    public function getTypesByName(string $name) : ?array {

        $return = [];

        foreach ($this->_types as $type) {

            if ($type->getName() === $name) {
                $return[] = $type;
            }

        }

        return (count($return) > 0) ? $return : NULL;

    }

    public function getTypeDescriptions() : array {

        $return = [];

        foreach ($this->_types as $type) {
            $return[] = $type->getDescription();
        }

        return $return;

    }

    /**
     * @param string $description
     * @return Type[]|null
     */
    public function getTypesByDescription(string $description) : ?array {

        $return = [];

        foreach ($this->_types as $type) {

            if ($type->getDescription() === $description) {
                $return[] = $type;
            }

        }

        return (count($return) > 0) ? $return : NULL;

    }

    public function toJson() : string {

        $return = [];

        foreach ($this->_types as $type) {
            $return[] = $type->getAllInformation();
        }

        return json_encode($return);

    }

    private function _parse() : void {

        $pattern = "/^Handle.*?(?:\n(?!\n).*)*\n\n/m";
        $matches = [];
        preg_match_all($pattern, $this->_dmidecodeOutput, $matches);

        foreach ($matches[0] as $match) {

            $lines = explode("\n", $match);
            $typeID = $this->_getDMIType($lines[0]);

            if (!isset(self::_TYPE_MAPPING[$typeID])) {
                continue;
            }

            $description = $lines[1];

            array_shift($lines);
            array_shift($lines);
            array_pop($lines);
            array_pop($lines);

            $properties = implode("\n", $lines);
            $fixed_properties = $this->_getTypeProperties($properties);

            $type = new Type(self::_TYPE_MAPPING[$typeID], $description, $fixed_properties);
            $this->_types[] = $type;

        }

    }

    private function _getDMIType(string $line) : int {

        $pattern = "/DMI type (\d+)/m";
        $matches = [];
        preg_match_all($pattern, $line, $matches);

        return (int) $matches[1][0];

    }

    private function _getTypeProperties(string $properties) : array {

        $pattern = '/\t(.+): (.+)/m';
        $matches = [];
        preg_match_all($pattern, $properties, $matches);

        return array_combine($matches[1], $matches[2]);

    }


}