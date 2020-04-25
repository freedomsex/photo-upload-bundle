# PhotoUploadBundle

Component for projects _FreedomSex_. 

Provides image file download service. The interface of the entity of the file. Presets path and file naming configurations. A usage strategy may turn out to be project specific.

## Default configuration

```yaml 
photo_upload:
    width: 600  # max width
    height: 800 # max height
    quality: 80 # jpeg quality 
    namer: 'upload_file_namer'
```

## Basic usage

```php
# PhotoController

use FreedomSex\PhotoUploadBundle\Services\FileUploader;
use FreedomSex\PhotoUploadBundle\Entity\FileInterface;

    public $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    public function upload(UploadedFile $file)
    {
        $entity = new Photo(); # implements FileInterface
        $this->fileUploader->upload($file, $entity);
    }
```
