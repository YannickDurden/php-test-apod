<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoogleController extends AbstractController
{
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect([], []);
    }

    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // this method still blank because we're using a GoogleAuthenticator
    }
}