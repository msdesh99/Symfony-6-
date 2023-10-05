<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


class FileUploader
{
    private $container;

    
    public function __construct(
        private $targetDirectory, //need to add service and arguments in services.yaml
        private SluggerInterface $slugger,
    )
   {    //dump($targetDirectory);die;
    }

    public function UploadYouTube(UploadedFile $avatarFile): string{
        $avatarfilename = md5(uniqid()). '.' .$avatarFile->guessClientExtension();
                $avatarFile->move(
                    $this->getTargetDirectory(), //parameters defined in services.yaml
                    $avatarfilename
                ); 
        return $avatarfilename;        
    }
    //https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try{
                    $file->move(
                        //$this->container->getParameter('uploads_dir'), //parameters defined in services.yaml
                        $this->getTargetDirectory(),
                        $newFilename);
                } catch (FileException $e){
                   // ... handle exception if something happens during file upload
                } 
        
        return $newFilename;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

}
?>