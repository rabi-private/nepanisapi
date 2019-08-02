<?php

namespace App\Extensions\Validation;


class Validator extends \Illuminate\Validation\Validator
{
    protected $formName;

    /**
     * Set form name
     *
     * @param $formName
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;
    }

    /**
     * Get the displayable name of the attribute.
     *
     * @param  string $attribute
     * @return string
     */
    public function getAttributeFromTranslations($name)
    {
        if (!empty($this->formName)) {
            foreach ($this->implicitAttributes as $key => $implicitAttribute) {
                if (in_array($name, $implicitAttribute)) {
                    $name = $key;
                    break;
                }
            }
            $formArray = array_get($this->translator->trans('validation.attributes'), $this->formName);
            return array_get($formArray, $name);
        }
        return parent::getAttributeFromTranslations($name);
    }
}


