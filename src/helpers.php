<?php
// Some useful functions

use Engelsystem\Application;
use Engelsystem\Config\Config;
use Engelsystem\Http\Request;
use Engelsystem\Renderer\Renderer;
use Engelsystem\Routing\UrlGenerator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Get the global app instance
 *
 * @param string $id
 * @return mixed
 */
function app($id = null)
{
    if (is_null($id)) {
        return Application::getInstance();
    }

    return Application::getInstance()->get($id);
}

/**
 * Get or set config values
 *
 * @param string|array $key
 * @param mixed        $default
 * @return mixed|Config
 */
function config($key = null, $default = null)
{
    $config = app('config');

    if (empty($key)) {
        return $config;
    }

    if (is_array($key)) {
        $config->set($key);
        return true;
    }

    return $config->get($key, $default);
}

/**
 * @param string $key
 * @param mixed  $default
 * @return Request|mixed
 */
function request($key = null, $default = null)
{
    $request = app('request');

    if (is_null($key)) {
        return $request;
    }

    return $request->input($key, $default);
}

/**
 * @param string $key
 * @param mixed  $default
 * @return SessionInterface|mixed
 */
function session($key = null, $default = null)
{
    $session = request()->getSession();

    if (is_null($key)) {
        return $session;
    }

    return $session->get($key, $default);
}

/**
 * @param string  $template
 * @param mixed[] $data
 * @return Renderer|string
 */
function view($template = null, $data = null)
{
    $renderer = app('renderer');

    if (is_null($template)) {
        return $renderer;
    }

    return $renderer->render($template, $data);
}

/**
 * @param string $path
 * @param array  $parameters
 * @return string
 */
function url($path, $parameters = [])
{
    return UrlGenerator::to($path, $parameters);
}
