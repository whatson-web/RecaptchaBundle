<?php

namespace WH\RecaptchaBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class RegisterParameterExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return [
            'wh_recaptcha' => $this->container->getParameter('wh_recaptcha'),
        ];
    }
}