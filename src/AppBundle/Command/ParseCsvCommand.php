<?php



namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCsvCommand extends ContainerAwareCommand{

    public function configure(){
        $this->setName('csv:parse')->setDescription('parses and saves csv infos in db');
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $container=$this->getContainer();
        $service= $container->get('csv_service');
        $csv = $service->saveInfos();
    }

}