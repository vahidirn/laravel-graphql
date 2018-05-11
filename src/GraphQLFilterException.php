<?php

namespace VahidIrn\GraphQLFilter;

class GraphQLFilterException extends \Exception
{
    public function __construct($message) {
        parent::__construct($message);
    }
}
