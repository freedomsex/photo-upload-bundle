<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming;


class NameParser
{
    public function filename($name)
    {
        $path = pathinfo($name);
        $ext = strtolower($path['extension']);
        $info = explode('_', $path['filename']);
        return substr($info[0], 0, 10) . '_' . $info[1] . '_' . $info[2] . '.' . $ext;
    }

    public function path($name)
    {
        $name = pathinfo($name)['filename'];
        $time = explode('_', $name)[2];
        return PathNamer::fullPath($name, $time);
    }

    public function added($name)
    {
        $name = pathinfo($name)['filename'];
        $timestamp = explode('_', $name)[2];
        return new \DateTime('@' . $timestamp);
    }

    public function size($name)
    {
        $name = pathinfo($name)['filename'];
        $size = explode('_', $name)[1];
        return explode('x', $size);
    }

    public function orient($size)
    {
        $result = '0';
        if ($size[0] > $size[1]) {
            $result = '1';
        }
        if (max($size) / min($size) < 1.23) {
            $result = '2';
        }
        return $result;
    }
}
