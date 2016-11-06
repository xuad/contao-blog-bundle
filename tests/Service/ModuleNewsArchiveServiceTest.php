<?php

namespace Xuad\BlogBundle\Test\DependencyInjection;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\CoreBundle\Routing\UrlGenerator;
use Xuad\BlogBundle\Model\NewsArchiveModel;
use Xuad\BlogBundle\Repository\NewsArchiveRepository;
use Xuad\BlogBundle\Service\ModuleNewsArchiveService;

/**
 * ModuleNewsArchiveServiceTest
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ModuleNewsArchiveServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectActive()
    {
        /** @var NewsArchiveRepository $newsArchiveRepository */
        $newsArchiveRepository = $this
            ->getMockBuilder('Xuad\BlogBundle\Repository\NewsArchiveRepository')
            ->disableOriginalConstructor()
            ->setMethods(['getArchiveObjectList'])
            ->getMock();

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this
            ->getMockBuilder('Contao\CoreBundle\Routing\UrlGenerator')
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
     * Returns a ContaoFramework instance.
     *
     * @param bool $noModels
     *
     * @return ContaoFrameworkInterface
     */
    private function mockContaoFramework($noModels = false)
    {
        /** @var ContaoFramework|\PHPUnit_Framework_MockObject_MockObject $framework */
        $framework = $this
            ->getMockBuilder('Contao\CoreBundle\Framework\ContaoFramework')
            ->disableOriginalConstructor()
            ->setMethods(['isInitialized', 'getAdapter'])
            ->getMock();

        return $framework;
    }
}