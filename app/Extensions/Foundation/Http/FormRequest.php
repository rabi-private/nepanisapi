<?php

namespace App\Extensions\Foundation\Http;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $validator = $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        );
        $validator->setFormName($this->getFormName());

        return $validator;
    }

    /**
     * Get form name.
     *
     * @return string
     */
    public function getFormName()
    {
        return defined('static::NAME') ? static::NAME : snake_case(class_basename(get_class($this)));
    }

    /**
     * create form error message.
     *
     * @param $rule
     * @param $replace
     * @return mixed
     */
    public function createMessage($rule, $replace)
    {
        if ($formName = $this->getFormName()) {
            if (array_has($replace, 'attribute')) {
                $formArray = array_get(trans('validation.attributes'), $this->getFormName());
                $replace['attribute'] = array_get($formArray, $replace['attribute']);
            }
        }
        return trans("validation.{$rule}", $replace);
    }
}
