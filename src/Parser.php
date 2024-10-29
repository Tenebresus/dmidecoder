<?php

namespace Tenebresus\Dmidecoder;

use Tenebresus\Dmidecoder\Type;

class Parser {

    private string $_dmidecodeOutput;
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

    private const string _DELIMITER = '        ';

    public function __construct(string $dmidecodeOutput) {

        $this->_dmidecodeOutput = $dmidecodeOutput;
        $this->_parse();

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

            $type = new Type(self::_TYPE_MAPPING[$typeID], $description);

            array_shift($lines);
            array_shift($lines);
            array_pop($lines);
            array_pop($lines);

            $test = implode("\n", $lines);
            print_r($test . "\n\n\n\n");

        }

    }

    private function _getDMIType(string $line) : int {

        $pattern = "/DMI type (\d+)/m";
        $matches = [];
        preg_match_all($pattern, $line, $matches);

        return (int) $matches[1][0];

    }

    // TODO: every batch of properties needs to be filtered out through regex to gather key value pairs per property
    private function _getTypeProperties(string $properties) : array {

        return [];

    }




}