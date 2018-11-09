<?php

namespace Common\Infrastructure\UserInterface\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractCSRFForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver) {
        $classNameStripped = $this->stripStaticClassName();

        $resolver->setDefaults(array(
                                   'csrf_protection' => TRUE,
                                   'csrf_field_name' => '_csrf_token_' . $classNameStripped,

                                   // a unique key to help generate the secret token
                                   'csrf_token_id'   => $classNameStripped . '_ITEM',
                               ));
    }

    private function stripStaticClassName(): string {
        return $this->stripClassName(static::class);
    }

    private function stripClassName($name): string {
        return str_replace("\\", "_", $name);
    }
}