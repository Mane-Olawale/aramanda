<?php

namespace Aramanda\Router\DataParser;



class RouteParser
{

    const VARIABLE_REGEX = <<<'REGEX'
    \{
        \s* ([a-zA-Z_][a-zA-Z0-9_-]*) \s*
    \}
    REGEX;

    const DEFAULT_DISPATCH_REGEX = '[\w]+';

    public function parse($route, $varRegex = RouteParser::DEFAULT_DISPATCH_REGEX)
    {
        $routeWithoutClosingOptionals = rtrim($route, ']');
        $numOptionals = strlen($route) - strlen($routeWithoutClosingOptionals);

        // Split on [ while skipping placeholders
        $sections = preg_split('~' . static::VARIABLE_REGEX . '(*SKIP)(*F) | \[~x', $routeWithoutClosingOptionals);
        if ($numOptionals !== count($sections) - 1) {
            // If there are any ] in the middle of the route, throw a more specific error message
            if (preg_match('~' . static::VARIABLE_REGEX . '(*SKIP)(*F) | \]~x', $routeWithoutClosingOptionals)) {
                die ('Optional segments can only occur at the end of a route') ;
            }
            die ("Number of opening '[' and closing ']' does not match");
        }

        $currentRoute = '';
        $routeDatas = [];
        foreach ($sections as $n => $section) {
            if ($section === '' && $n !== 0) {
                die ('Empty optional part');
            }

            $currentRoute .= $section;
            $routeDatas[] = static::parseVariables($currentRoute, $varRegex);
        }
        return $routeDatas;
    }


  /**
   * Parses a route string that does not contain optional segments.
   *
   * @param string
   * @return mixed[]
   */
    private function parseVariables($route, $varRegex)
    {
        if (!preg_match_all(
            '~' . static::VARIABLE_REGEX . '~x', $route, $matches,
            PREG_OFFSET_CAPTURE | PREG_SET_ORDER
        )) {
            return [$route];
        }

        $offset = 0;
        $routeData = [];
        foreach ($matches as $set) {
            if ($set[0][1] > $offset) {
                $routeData[] = substr($route, $offset, $set[0][1] - $offset);
            }
            $routeData[] = [
                $set[1][0],
                $varRegex
            ];
            $offset = $set[0][1] + strlen($set[0][0]);
        }

        if ($offset !== strlen($route)) {
            $routeData[] = substr($route, $offset);
        }

        return $routeData;
    }

}
