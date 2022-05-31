<?php


namespace App\Repositories;

use App\Models\MailAttachment;
use DB;

class MailAttachmentRepository
{
    private $mailAttachment;

    public function __construct(MailAttachment $mailAttachment)
    {
        $this->mailAttachment = $mailAttachment;
    }

    public function create($attributes)
    {
        return $this->mailAttachment->create($attributes);
    }

    public function insert($attributes)
    {
        return $this->mailAttachment->insert($attributes);
    }

    public function all()
    {
        return $this->mailAttachment->all();
    }

    public function find($id)
    {
        return $this->mailAttachment->find($id);
    }

    public function update($id, array $attributes)
    {
        return $this->mailAttachment->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->mailAttachment->find($id)->delete();
    }

    public function forceDelete($id)
    {
        return $this->mailAttachment->find($id)->forceDelete();
    }

    public function findMailAttachmentByMailId($mail_id)
    {
        return $this->mailAttachment->where('mail_id', $mail_id)->get();
    }

    public function setFile($request)
    {
        $item = $this->mailAttachment->find($request->key);

        $this->mailAttachment->where('mail_id', $item->mail_id)->update([$request->type => 0]);
        $item->{$request->type} = 1;
        $item->save();
        return $item;
    }


}