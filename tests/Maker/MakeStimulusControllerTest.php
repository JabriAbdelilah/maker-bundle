<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Tests\Maker;

use Symfony\Bundle\MakerBundle\Maker\MakeStimulusController;
use Symfony\Bundle\MakerBundle\Test\MakerTestCase;
use Symfony\Bundle\MakerBundle\Test\MakerTestRunner;

class MakeStimulusControllerTest extends MakerTestCase
{
    protected function getMakerClass(): string
    {
        return MakeStimulusController::class;
    }

    public function getTestDetails()
    {
        yield 'it_generates_stimulus_controller' => [$this->createMakerTest()
            ->run(function (MakerTestRunner $runner) {
                $runner->runMaker(
                    [
                        // controller name
                        'custom',
                    ]);

                $this->assertFileExists($runner->getPath('assets/controllers/custom_controller.js'));
            }),
        ];
    }
}
