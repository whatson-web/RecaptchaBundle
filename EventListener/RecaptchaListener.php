<?php

namespace WH\RecaptchaBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use WH\RecaptchaBundle\Services\RecaptchaValidator;

/**
 * Class RecaptchaListener
 *
 * @package WH\RecaptchaBundle\EventListener
 */
class RecaptchaListener
{
    private $recaptchaValidator;

    public function __construct(RecaptchaValidator $recaptchaValidator)
    {
        $this->recaptchaValidator = $recaptchaValidator;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->request->has('g-recaptcha-response')) {
            return;
        }

        $gRecaptchaResponse = $request->request->get('g-recaptcha-response');

        $request->request->remove('g-recaptcha-response');

        if (!$this->recaptchaValidator->isResponseValid($gRecaptchaResponse)) {
            throw new AccessDeniedException('Protection anti-spam détectée');
        }
    }
}