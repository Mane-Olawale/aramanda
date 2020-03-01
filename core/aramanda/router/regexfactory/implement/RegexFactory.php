<?php

namespace Aramanda\Router\RouterFactory\Implement;

//use Aramanda\Exception\InvalidRouteException;
//use Aramanda\Router\Route;

interface RouterFactory
{

    /**
     * @return int
     */
    public function getApproxChunkSize();

    /**
     * @return mixed[]
     */
    public function processChunk($regexToRoutesMap);

    /**
    * @return void
    */
    public function addRoute($httpMethod, $routeData, $handler);

    /**
     * @return mixed[]
     */
    public function getData();

    /**
     * @return mixed[]
     */
    private function generateVariableRouteData();

    /**
     * @param int
     * @return int
     */
    private function computeChunkSize($count);

    /**
     * @param mixed[]
     * @return bool
     */
    private function isStaticRoute($routeData);

    /**
    * @return void
    */
    private function addStaticRoute($httpMethod, $routeData, $handler);

    private function addVariableRoute($httpMethod, $routeData, $handler);

    /**
     * @param mixed[]
     * @return mixed[]
     */
    private function buildRegexForRoute($routeData);

    /**
     * @param string
     * @return bool
     */
    private function regexHasCapturingGroups($regex);


}
