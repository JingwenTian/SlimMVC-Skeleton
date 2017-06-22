<?php

namespace App\controller\exception;


class ModelNotFoundException extends \RuntimeException
{

    protected $model;

    protected $ids;

    public function setModel($model, $ids = [])
    {
        $this->model = $model;
        $this->ids = array_wrap($ids);
        $this->code = 404;
        $this->message = "No query results for model [{$model}]";

        if (count($this->ids) > 0) {
            $this->message .= ' ' . implode(', ', $this->ids);
        } else {
            $this->message .= '.';
        }

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getIds()
    {
        return $this->ids;
    }
}