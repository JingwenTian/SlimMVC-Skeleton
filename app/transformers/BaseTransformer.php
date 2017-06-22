<?php

namespace App\transformers;


use App\interfaces\TransformerInterface;
use Illuminate\Support\Collection;

/**
 * Class BaseTransformer
 * @package App\transformers
 */
abstract class BaseTransformer implements TransformerInterface
{

    protected $path;

    public function __construct($path = null)
    {
        $this->path = $path;
    }


    public function transform($data)
    {
        $data = collect($data);

        $transformData = $this->transformData($data);

        return $transformData;
    }


    abstract public function transformData(Collection $model);

}