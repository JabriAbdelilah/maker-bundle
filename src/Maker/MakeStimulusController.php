<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

/**
 * @author Abdelilah Jabri <jbrabdelilah@gmail.com>
 *
 * @internal
 */
final class MakeStimulusController extends AbstractMaker
{
    public const SUFFIX = '_controller.js';

    public const PATH = 'assets/controllers/';

    public static function getCommandName(): string
    {
        return 'make:stimulus-controller';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Stimulus controller';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the stimulus controller (e.g. <fg=yellow>hello</>)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeStimulusController.txt'));
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $controllerName = $input->getArgument('name');
        $fileName = $controllerName.self::SUFFIX;
        $filePath = self::PATH.$fileName;

        $generator->generateFile(
            $filePath,
            'stimulus/Controller.tpl.php'
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next:',
            sprintf('- Open <info>%s</info> and add the code you need', $filePath),
            sprintf('- Use the controller in your template as <info><div data-controller="%s"></div></info>', $controllerName),
            'Find the documentation at <fg=yellow>https://github.com/symfony/stimulus-bridge</>',
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            WebpackEncoreBundle::class,
            'webpack-encore-bundle'
        );
    }
}
