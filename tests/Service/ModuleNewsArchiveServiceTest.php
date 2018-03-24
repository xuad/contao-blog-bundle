<?php

namespace Xuad\BlogBundle\Test\DependencyInjection;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\CoreBundle\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;
use Xuad\BlogBundle\Model\NewsArchiveModel;
use Xuad\BlogBundle\Repository\NewsArchiveRepository;
use Xuad\BlogBundle\Service\ModuleNewsArchiveService;

/**
 * Class ModuleNewsArchiveServiceTest
 *
 * @package Xuad\BlogBundle\Test\DependencyInjection
 */
class ModuleNewsArchiveServiceTest extends TestCase
{
    public function testInjectActive() : void
    {
        /** @var NewsArchiveRepository $newsArchiveRepository */
        $newsArchiveRepository = $this
            ->getMockBuilder(NewsArchiveRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getArchiveObjectList'])
            ->getMock();

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this
            ->getMockBuilder(UrlGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $activeId = 1;
        $newsArchiveModel = new NewsArchiveModel();
        $newsArchiveModel
            ->setId($activeId);

        $newsArchiveService = new ModuleNewsArchiveService(
            $this->mockContaoFramework(),
            $newsArchiveRepository,
            $urlGenerator
        );

        $this->assertEquals(true, $newsArchiveService->injectActive([$newsArchiveModel], $activeId)[0]->isActive());

        $newsArchiveModel->setActive(false);
        $this->assertEquals(false, $newsArchiveService->injectActive([$newsArchiveModel], 1337)[0]->isActive());
    }

    /**
     * @param bool $noModels
     *
     * @return ContaoFrameworkInterface
     */
    private function mockContaoFramework($noModels = false) : ContaoFrameworkInterface
    {
        /** @var ContaoFramework|\PHPUnit_Framework_MockObject_MockObject $framework */
        $framework = $this
            ->getMockBuilder(ContaoFramework::class)
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', 'getAdapter'])
            ->getMock();

        return $framework;
    }
}