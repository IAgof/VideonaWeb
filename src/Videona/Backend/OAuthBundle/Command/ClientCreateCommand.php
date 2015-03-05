<?php

/*
 * This file is part of the Videona code project.
 * 
 * Copyright (C) 2015 Videona Socialmedia SL
 * http://www.videona.com
 * info@videona.com
 *
 * All rights reserved
 */

namespace Videona\Backend\OAuthBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ClientCreateCommand
 *
 * @author vlf
 */
class ClientCreateCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('videona:oauth:client:create')
                ->setDescription('Creates a new client')
                ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets the redirect uri. Use multiple times to set multiple uris.', null)
                ->addOption('grant-type', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Set allowed grant type. Use multiple times to set multiple grant types', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);
        $output->writeln(sprintf('Added a new client with public id <info>%s</info>, secret <info>%s</info>.', $client->getPublicId(), $client->getSecret()
        ));
    }

}
