<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\BaseRepository;

abstract class BaseService {
    /**
     * @var BaseRepository
     */
    private $repository;

    /**
     * @param BaseRepository
     */
    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param array
     * @param string
     * @throws Exception
     * @return string
     */
    protected function resolveParam (array $data, string $param): string {
        if (empty($data[$param])) {
            throw new Exception("Could not find parameter `{$param}`. Please check your input", 500);
        }

        return $data[$param];
    }
}