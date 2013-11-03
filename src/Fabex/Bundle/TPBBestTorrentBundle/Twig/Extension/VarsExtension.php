<?php
namespace Fabex\Bundle\TPBBestTorrentBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class VarsExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'TPBBestTorrentBundle.extension';
    }

    public function getFilters() {
        return array(
            'json_decode'   => new \Twig_Filter_Method($this, 'jsonDecode'),
        );
    }

    public function getFunctions() {
        return array(
            'in_array'   => new \Twig_Function_Method($this, 'inArray'),
            'split'   => new \Twig_Function_Method($this, 'mySplit'),
            'uniq_id'   => new \Twig_Function_Method($this, 'uniqId'),
        );
    }

    public function jsonDecode($str) {
        return json_decode($str);
    }

    public function mySplit($pattern, $str) {
        return preg_split('/'.$pattern.'/', $str);
    }

    public function inArray($needle, array $haystack) {
        return in_array($needle, $haystack);
    }

    public function uniqId($prefix) {
        return uniqid($prefix);
    }
}