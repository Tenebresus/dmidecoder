<?php

namespace Tenebresus\Dmidecoder;

class Parser {

    private string $_dmidecodeOutput;
    private array $_types;
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

    private function _parse() : void {



    }



}