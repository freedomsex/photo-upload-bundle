<?php


namespace FreedomSex\PhotoUploadBundle\Services\Naming;


class FileNameParser
{
    private $data;

    public function parse($fileName)
    {
        $this->data = pathinfo($fileName);
        $parts = $this->parts();
        $this->data['prefix'] = $parts[0];
        $this->data['sizes'] = $parts[1];
        $this->data['added'] = $parts[2];
    }

    public function filename()
    {
        return $this->data['filename'];
    }

    public function name()
    {
        return $this->data['basename'];
    }

    public function extension()
    {
        return $this->data['extension'];
    }

    public function prefix()
    {
        return $this->data['prefix'];
    }

    public function dimensions()
    {
        return explode('x', $this->data['sizes']);
    }

    public function added()
    {
        return $this->data['added'];
    }

    public function parts()
    {
        return explode('_', $this->filename());
    }

    public function path($name)
    {
        $name = pathinfo($name)['filename'];
        $time = explode('_', $name)[2];
        return PathNamer::fullPath($name, $time);
    }

    public function orientation()
    {
        $result = '0';
        $sizes = $this->dimensions();
        if ($sizes[0] > $sizes[1]) {
            $result = '1';
        }
        if (max($sizes) / min($sizes) < 1.23) {
            $result = '2';
        }
        return $result;
    }
}
