<?php

namespace FreedomSex\PhotoUploadBundle\Services;

use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Binary\BinaryInterface;

class FilterService
{
    /**
     * @var DataManager
     */
    protected $dataManager;

    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @var CacheManager
     */
    protected $cacheManager;


    /**
     * @param DataManager     $dataManager
     * @param FilterManager   $filterManager
     * @param CacheManager    $cacheManager
     * @param SignerInterface $signer
     */
    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        CacheManager $cacheManager
    ) {
        $this->dataManager   = $dataManager;
        $this->filterManager = $filterManager;
        $this->cacheManager = $cacheManager;
    }

    public function defaultImage($filter)
    {
        return $this->dataManager->getDefaultImageUrl($filter);
    }

    public function stored($path, $filter)
    {
        return $this->cacheManager->isStored($path, $filter);
    }

//    public function image()
//    {
//        if ($this->stored($path, $filter)) {
//            $this->cacheManager->;
//        } else {
//            return $this->handle($path, $filter);
//        }
//    }

    /**
     * @param $path
     * @param $filter
     * @return BinaryInterface|null
     */
    public function image($path, $filter)
    {
        $image = null;
        try {
            $image = $this->dataManager->find($filter, $path);
        } catch (NotLoadableException $e) {
            $path = $this->defaultImage($filter);
            $image = $this->dataManager->find($filter, $path);
        }
        $image = $this->filterManager->applyFilter($image, $filter);
        $this->saveCache($image, $path, $filter);
        return $image;
    }

    public function filteredImage($path, $filter)
    {
        $image = $this->dataManager->find($filter, $path);
        $image = $this->filterManager->applyFilter($image, $filter);
        return $image;
    }

    public function dumpImage($path, $filter)
    {
        if (!$this->stored($path, $filter)) {
            $image = $this->filteredImage($path, $filter);
            $this->saveCache($image, $path, $filter);
        }
    }

    private function relativeUrl($path)
    {
        $result = parse_url($path, PHP_URL_PATH);
        return $result;
    }

    /**
     * @param Request $request
     * @param string  $path
     * @param string  $filter
     *
     * @throws \RuntimeException
     * @throws BadRequestHttpException
     *
     * @return RedirectResponse
     */
    public function filter($path, $filter)
    {
        $this->dumpImage($path, $filter);
        $result = $this->cacheManager->getBrowserPath($path, $filter);
        return $this->relativeUrl($result);
    }

    /**
     *
     * @param type $path
     * @param type $filter
     * @return BinaryInterface
     */
    public function prepare($path, $filter='upload')
    {
        $info = pathinfo($path);
        $image = $this->filteredImage($info['basename'], $filter);
        file_put_contents($path, $image->getContent());
        return $image;
    }

    public function resource($name, $dir, $file, $filter = 'thumbnail')
    {
        if (!$file) {
            $file = $this->dataManager->getDefaultImageUrl($filter);
        }
        $image = $this->filteredImage($file, $filter);
        $this->saveCache($image, $dir.'/'.$name, $filter);
        return $image;
    }

    public function saveCache($image, $path, $filter)
    {
        if (!$this->stored($path, $filter)) {
            $this->cacheManager->store($image, $path, $filter);
        }
    }

    public function clearCache($path, $filter)
    {
        if ($this->stored($path, $filter)) {
            $this->cacheManager->remove($path, $filter);
        }
    }

}
