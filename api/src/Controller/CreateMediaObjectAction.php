<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\MediaObject;
use App\Security\Voter\VoterAttribute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class CreateMediaObjectAction extends AbstractController
{
    public function __construct(private ValidatorInterface $validator) {}

    public function __invoke(Request $request): MediaObject
    {
        $mediaObject = new MediaObject();
        if (!$this->isGranted(VoterAttribute::CREATE, $mediaObject)) {
            $this->createAccessDeniedException();
        }

        /** @var ?UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        $fileName = $request->request->get('fileName');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('You forgot to upload image');
        }

        if (!$uploadedFile->isValid()) {
            throw new UploadException($uploadedFile->getErrorMessage());
        }

        if (($mimeType = $uploadedFile->getMimeType()) === null) {
            throw new FileException("Couldn't resolve mime type.");
        }

        if ($fileName === null) {
            $fileName = $uploadedFile->getClientOriginalName();
        }

        $mediaObject->setFileName($fileName);
        $mediaObject->setMimeType($mimeType);
        $mediaObject->setFile($uploadedFile);

        $this->validator->validate($mediaObject);

        return $mediaObject;
    }
}
