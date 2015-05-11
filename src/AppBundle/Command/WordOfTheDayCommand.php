<?php



namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WordOfTheDayCommand extends ContainerAwareCommand{

    public function configure(){
        $this->setName('wotd:get')->setDescription('gets the word of the day');
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $container=$this->getContainer();
        $service= $container->get('wotd_service');
        $wotd = $service->getWotd();
    }

}