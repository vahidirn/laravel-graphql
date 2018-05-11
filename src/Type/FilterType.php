<?php

namespace VahidIrn\GraphQLFilter\Type;

use VahidIrn\GraphQLFilter\GraphQLFilter;
use VahidIrn\GraphQLFilter\GraphQLFilterException;

use ErrorException;
use ReflectionClass;
use Folklore\GraphQL\Support\InputType;

class FilterType extends InputType
{
    protected $model;
    protected $fieldFilterQuerys = null;
    protected $fieldOverrides = [];
    
    public function attributes() {
        $modelName = $this->getModelName();
        $typeName = $this->getTypeName();
        return [
            'name' => $typeName,
            'description' => 'Filter parameters for listing ' . str_plural($modelName)
        ];
    }
    
    public function fields() {
        return $this->fieldsFromModel();
    }
    
    public function getModelName() {
        return (new ReflectionClass($this->getModel()))->getshortName();
    }
    
    public function getTypeName() {
        return $this->getModelName() . 'Filter';
    }
    
    public function getModel() {
        if (!isset($this->model)) {
            throw new GraphQLFilterException('model property must be set');
        }
        return $this->model;
    }
    
    protected function getFieldFilterQuerys() {
        return $this->fieldFilterQuerys;
    }
    
    protected function getFieldOverrides() {
        return $this->fieldOverrides;
    }
    
    protected function fieldsFromModel() {
        $model = $this->getModel();
        $fieldFilterQuerys = $this->getFieldFilterQuerys();
        $fieldOverrides = $this->getFieldOverrides();
        return GraphQLFilter::fieldsFromModel($model, $fieldFilterQuerys, $fieldOverrides);
    }
}
