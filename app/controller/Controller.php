<?php

namespace App\controller;

use App\interfaces\TransformerInterface;
use Interop\Container\ContainerInterface;


abstract class Controller
{
    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->_init();
    }

    /**
     * @return [type] [description]
     */
    protected function _init()
    {
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return mixed
     */
    protected function responseJson($data = [], $code = 200, $message = '')
    {
        return $this->container->response->withStatus($code)
            ->withHeader("Content-Type", "application/json")
            ->withJson(['code' => $code, 'data' => $data, 'message' => $message]);
    }

    /**
     * @param $data
     * @param int $code
     * @param TransformerInterface $transformer
     * @return mixed
     */
    protected function responseSuccess($data, $code = 200, TransformerInterface $transformer = null)
    {
        if (!is_null($transformer)) {
            $data = $transformer->transform($data);
        }

        return $this->responseJson($data, $code, 'success');
    }

    /**
     * @param $data
     * @param TransformerInterface|null $transformer
     * @param null $page
     * @return mixed
     */
    protected function responseArray($data, TransformerInterface $transformer = null, $page = null)
    {
        if (!is_null($transformer)) {
            $list = [];
            foreach ($data as $val) {
                $list[] = $transformer->transform($val);
            }
            $data = $list;
        }
        $return = [
            'list' => $data
        ];
        if (!is_null($page)) {
            $return = array_merge($return, $page);
        }

        return $this->responseSuccess($return);
    }

    /**
     * @param int $code
     * @param string $message
     * @return mixed
     */
    protected function responseFail($code = 400, $message = "")
    {
        return $this->responseJson([], $code, $message);
    }

}