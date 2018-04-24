<?php

namespace WH\RecaptchaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecaptchaType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'label' => false,
                'attr'  => [
                    'class' => 'parent-form-need-recaptcha-validation',
                ],
            ]
        );
    }
}