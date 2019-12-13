<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CopyrightExtension extends AbstractExtension
{
    // public function getFilters(): array
    // {
    //     return [
    //         // If your filter generates SAFE HTML, you should add a third
    //         // parameter: ['is_safe' => ['html']]
    //         // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
    //         new TwigFilter('filter_name', [$this, 'doSomething']),
    //     ];
    // }
    private $params = null;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('copyright', [$this, 'doMyCopyright']),
        ];
    }

    public function doMyCopyright()
    {
        $copyright = "&copy;";
        $since = $this->params->get('copyrightSince');
        if (null == $since)
        {
            $since = date('Y');
        }
        
        $copyright .= $since;

        if ($since < date('Y'))
        {
            $copyright .= "-".date('Y');
        }        
        return html_entity_decode($copyright);
    }
}