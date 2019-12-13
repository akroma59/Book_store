<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BookListener
{
    public function makeBook(ResponseEvent $event)
    {

        if (!$event->isMasterRequest()) {
            return;
        }
        // Retrieve the Kernel response
        $response = $event->getResponse();

        // Retrieve the HTML content of the response
        $content = $response->getContent();

        /*$content = preg_replace(
            '#<ul>#iU',
            '<ol>',
            $content
        );

        $content = preg_replace(
            '#</ul>#iU',
            '</ol>',
            $content
        );*/

        preg_match_all("#(<li>).{1,}(</li>)#",$content,$matches);
        $i = 1;
        $li[] = '<ul id="books">';
        foreach ($matches[0] as $match) {
            $li[] = "<li>".$i." : ".strip_tags($match)."</li>";
            $i++;
        }
        $li[] = '</ul>';

        $content = preg_replace("#\<ul\b[^>]*>([.\n\s\t\>]*<li>.*<\/li>){1,}[.\n\s\t\>]*<\/ul>#",implode($li),$content);

        // Set the updated $content to the $response
        // tu renvois le contenu dans la reponse
        $response->setContent($content);

        // Update the response
        // tu renvois la reponse dans l'évenement
        $event->setResponse($response);
    }
}