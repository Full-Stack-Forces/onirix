<?php

namespace Webcup;

class View
{
    const IS_PUBLIC = 1;
    const IS_PRIVATE = 2;
    const IS_ADMIN = 3;
    private $title;
    private $path;
    private $publicController;
    private $privateController;
    private $withHeader;
    private $withFooter;
    private $styles;
    private $styleLinks;
    private $scripts;
    private $scriptLinks;
    private $privacy;

    public function __construct($title, $path, $options = array(), $privacy = self::IS_PRIVATE)
    {
        $this->setTitle($title);
        $this->setPath($path != '' ? VIEWS_DIR . $path : '');
        $this->setPublicController(array_key_exists('public_controller', $options) ? CONTROLLERS_DIR . $options['public_controller'] : '');
        $this->setPrivateController(array_key_exists('private_controller', $options) ? CONTROLLERS_DIR . $options['private_controller'] : '');
        $this->setStyles(array_key_exists('styles', $options) ? $options['styles'] : array());
        $this->setStyleLinks(array_key_exists('style_links', $options) ? $options['style_links'] : array());
        $this->setScripts(array_key_exists('scripts', $options) ? $options['scripts'] : array());
        $this->setScriptLinks(array_key_exists('script_links', $options) ? $options['script_links'] : array());
        $this->setWithHeader(array_key_exists('with_header', $options) ? $options['with_header'] : true);
        $this->setWithFooter(array_key_exists('with_footer', $options) ? $options['with_footer'] : true);
        $this->setPrivacy($privacy);
    }

    public function title()
    {
        return $this->title;
    }

    public function path()
    {
        return $this->path;
    }

    public function publicController()
    {
        return $this->publicController;
    }

    public function privateController()
    {
        return $this->privateController;
    }

    public function withHeader()
    {
        return $this->withHeader;
    }

    public function withFooter()
    {
        return $this->withFooter;
    }

    public function styles()
    {
        return $this->styles;
    }

    public function styleLinks()
    {
        return $this->styleLinks;
    }

    public function scripts()
    {
        return $this->scripts;
    }

    public function scriptLinks()
    {
        return $this->scriptLinks;
    }

    public function privacy()
    {
        return $this->privacy;
    }

    public function isPublic()
    {
        return $this->privacy == self::IS_PUBLIC;
    }

    public function isPrivate()
    {
        return $this->privacy == self::IS_PRIVATE || $this->privacy == self::IS_ADMIN;
    }

    public function isAdmin()
    {
        return $this->privacy == self::IS_ADMIN;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setPublicController($publicController)
    {
        $this->publicController = $publicController;
    }

    public function setPrivateController($privateController)
    {
        $this->privateController = $privateController;
    }

    public function setWithHeader($withHeader)
    {
        $this->withHeader = $withHeader;
    }

    public function setWithFooter($withFooter)
    {
        $this->withFooter = $withFooter;
    }

    private static function addToArray($values, $newValues)
    {
        foreach ($newValues as $value) {
            if (is_array($value)) {
                $values += $value;
            } elseif ($value != '' && !in_array($value, $values)) {
                $values[] = $value;
            }
        }

        return $values;
    }

    public function setStyles()
    {
        $this->styles = self::addToArray(array(), func_get_args());
    }

    public function addStyles()
    {
        $this->styles = self::addToArray($this->styles, func_get_args());
    }

    public function setStyleLinks()
    {
        $this->styleLinks = self::addToArray(array(), func_get_args());
    }

    public function addStyleLinks()
    {
        $this->styleLinks = self::addToArray($this->styleLinks, func_get_args());
    }

    public function setScripts()
    {
        $this->scripts = self::addToArray(array(), func_get_args());
    }

    public function addScripts()
    {
        $this->scripts = self::addToArray($this->scripts, func_get_args());
    }

    public function setScriptLinks()
    {
        $this->scriptLinks = self::addToArray(array(), func_get_args());
    }

    public function addScriptLinks()
    {
        $this->scriptLinks = self::addToArray($this->scriptLinks, func_get_args());
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }
}
