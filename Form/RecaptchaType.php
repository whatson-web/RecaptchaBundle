<?php

namespace WH\RecaptchaBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecaptchaType extends AbstractType
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            [
                $this,
                'onPreSubmit',
            ]
        );
    }

    public function onPreSubmit(FormEvent $event)
    {
        $request = Request::createFromGlobals();

        if ($request->request->has('g-recaptcha-response')) {
            $gRecaptchaResponse = $request->request->get('g-recaptcha-response');

            $request->request->remove('g-recaptcha-response');

            if (!$this->container->get('wh_recaptcha.validator')->isResponseValid($gRecaptchaResponse)) {
                $event->getForm()->addError(new FormError('Vérification anti-spam échouée'));
            }
        }
    }
}