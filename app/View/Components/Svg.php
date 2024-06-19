<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Svg extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $src, public string $class = '')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $publicPath = resource_path('front/' . $this->src);

        // Create the dom document as per the other answers
        $svg = new \DOMDocument();
        $svg->load($publicPath);
        if ($this->class) {
            $svg->documentElement->setAttribute('class', $this->class);
        }
        $svg->documentElement->removeAttribute('style');
        $svg->documentElement->removeAttribute('id');

        $style = $svg->documentElement->getElementsByTagName('style')->item(0);
        if ($style) {
            $style->parentNode->removeChild($style);
        }

        $output = $svg->saveXML($svg->documentElement);

        return $output;
    }
}
