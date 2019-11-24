<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Result;

class Route
{
    public $name;
    public $pattern;
    public $handler;
    public $tokens;
    public $methods;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }

    public function match(ServerRequestInterface $request): ?Result
    {
            if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) {
               return null;
            }

            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches)  {
                $argument = $matches[1];
                $replace = $route->tokens[$argument] ?? '[^}]+';
                return '(?P<' . $argument . '>)' . $replace . ')';
            }, $this->pattern);


            $path = $request->getUri()->getPath();

            if (!preg_match('~^' . $pattern . '$~i', $path, $matches)) {
                return null;
            }
        }
         return new Result(
                           $this->name,
                           $this->handler,
                           array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
                       );
    }

        public function generate($name, array $params = []): ?string
        {
            $arguments = array_filter($params);

            if ($name !== $this->name) {
                return null;
            }

                $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
                    $argument = $matches[1];

                    if (!array_key_exists($argument, $arguments)) {
                        throw new \InvalidArgumentException('Missing parameter "' . $argument . '""');
                    }
                    return $arguments[$argument];
                }, $this->pattern);

                return $url;

        }
}