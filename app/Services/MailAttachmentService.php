<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\MailAttachmentRepository;

class MailAttachmentService
{
    private $mailAttachRepo;

    public function __construct(MailAttachmentRepository $mailAttachRepo)
    {
        $this->mailAttachRepo = $mailAttachRepo;
    }

    public function index()
    {
        return $this->mailAttachRepo->all();
    }

    public function findByID($id)
    {
        return $this->mailAttachRepo->find($id);
    }

    public function create($mailId, $mailFiles, $options)
    {
        $count   = count($mailFiles);
        $i       = 0;
        foreach ($mailFiles as $file) {
            $pdf = new FileUploadService($file, $options);
            $pdf->save();
            $files[]= [
                'id'        => Str::uuid(),
                'mail_id'   => $mailId,
                'filename'  => $pdf->getSavedFile(),
                // 'is_cover'  => $i == 0 ? 1 : 0,
                // 'is_hover'  => $count > 1 ? ($i == 1 ? 1 : 0) : 1,
            ];
            $i++;
        }

        return $this->mailAttachRepo->insert($files);
    }

    public function updateFile($mailId, $mailFiles, $options)
    {
        foreach ($mailFiles as $i => $file) {
            $pdf = new ImageUploadService($file, $options);
            $pdf->save();
            $files[]= [
                'id'        => Str::uuid(),
                'mail_id'   => $mailId,
                'filename'  => $pdf->getSavedFile(),
            ];
        }

        return $this->mailAttachRepo->insert($files);
    }

    public function read($id)
    {
        return $this->mailAttachRepo->find($id);
    }

    public function update($data, $id)
    {
        return $this->mailAttachRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->mailAttachRepo->delete($id);
    }

    public function forceDelete($id)
    {
        $this->deleteFile($id);
        return $this->mailAttachRepo->forceDelete($id);
    }

    public function findMailAttachmentById($mail_id)
    {
        return $this->mailAttachRepo->findMailAttachmentByMailId($mail_id);
    }

    public function deleteFile($id)
    {
        $item = $this->findByID($id);
        \Storage::disk('local')->delete(str_replace('app/', '', $item->filename));
        \Storage::disk('local')->delete(str_replace('app/', '', str_replace('.pdf', '-thumbnail.pdf', $item->filename)));
    }

    public function setFile($request)
    {
        return $this->mailAttachRepo->setFile($request);
    }
}
