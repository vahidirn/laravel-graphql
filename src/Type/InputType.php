<?php
namespace VahidIrn\GraphQLFilter\Type;

use GraphQL\Type\Definition\InputObjectType;
use Folklore\GraphQL\Support\Type;

class InputType extends Type
{
    public function toType()
    {
        return new InputObjectType($this->toArray());
    }
}
