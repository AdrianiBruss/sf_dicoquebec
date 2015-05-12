<?php



namespace AppBundle\Twig;



use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension implements ContainerAwareInterface{
    private $container;
    public function setContainer(ContainerInterface $container = null){
        $this->container=$container;
    }
    public function getFilters(){
        return array(
          new \Twig_SimpleFilter("category",array($this,"categoryFilter"))
        );
    }

    public function categoryFilter($content){
        switch($content){
            case "v":
                return "verbe";
                break;
            case "e":
                return "expression";
                break;
            case "d":
                return "déformation";
                break;
            case "s":
                return "sacre";
                break;
        }

    }
    public function getName(){
        return 'app_extension';
    }
}