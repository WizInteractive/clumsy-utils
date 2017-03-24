<?php

namespace Wizclumsy\Utils\Validation;

class Identities
{
    public $types = [

        'pt_nif' => 'Wizclumsy\Utils\Validation\PT\Identities@nif',
    ];

    public function validate($attribute, $value, $parameters)
    {
        $type = head($parameters);

        if (!$type) {
            throw new \Exception('Cannot use "id" validator without specifying parameters (i.e. "id:code")');
        }

        list($object, $method) = explode('@', $this->types[$type]);

        return with(new $object)->$method($attribute, $value, $parameters);
    }
}
