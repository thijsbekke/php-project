<?php

namespace Rest;

use Router\IController;

/**
 * Class RestController
 * @package Rest
 */
class RestController implements IController
{

    protected $object = null;

    public function __construct(IRest $object)
    {
        $this->object = $object;
    }

    /**
     * Maak alle Rest routes aan met je $route als endpoint
     * @param $route
     * @return array
     */
    public function methods($route)
    {
        if (empty($route)) {
            return [];
        }

        $object = $this->object;
        return [
            new Method("get", $route, function () use ($object) {
                return $object->index();
            }),
            new Method("get", $route . '(:num)', function ($data) use ($object) {
                return $object->show($data);
            }),
            new Method("get", $route . '(:num)/edit', function ($data) use ($object) {
                return $object->edit($data);
            }),
            new Method("get", $route . '(:num)/delete', function ($data) use ($object) {
                return $object->delete($data);
            }),
            new Method("get", $route . 'create', function ($data) use ($object) {
                return $object->create($data);
            }),
        ];
    }


}
