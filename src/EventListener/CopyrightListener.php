<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class CopyrightListener
{
    public function makeMyCopyright(ResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType())
        {
            return;
        }
        
        $date = (new \DateTime())->format('Y');
        $html = "&copy; 2009 - ".$date;
        
        // Retrieve the Kernel response
        $response = $event->getResponse();

        // Retrieve the HTML content of the response
        $content = $response->getContent();

        $content = preg_replace(
            '#<copyright>#iU',
            '<span>'.$html.'</span>',
            $content
        );

        // Set the updated $content to the $response
        $response->setContent($content);

        // Update the response
        $event->setResponse($response);
    } 
}