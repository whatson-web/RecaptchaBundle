<?php

namespace WH\RecaptchaBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RecaptchaValidator
 *
 * @package WH\RecaptchaBundle\Services
 */
class RecaptchaValidator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $gRecaptchaResponse
     *
     * @return bool
     */
    public function isResponseValid($gRecaptchaResponse)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            [
                'secret'   => $this->container->getParameter('wh_recaptcha.private_key'),
                'response' => $gRecaptchaResponse,
            ]
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        dump($gRecaptchaResponse);
        dump($response);

        if (isset($response['success']) && $response['success'] == true) {
            return true;
        }

        return false;
    }
}