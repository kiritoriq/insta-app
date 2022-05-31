<?php

namespace App\Models;

use App\Models\Conserns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailAttachment extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table        = 'mail_attachment';
    protected $incrementing = false;
    protected $fillable     = [ 'name',
                            'description',
                            'filename',
                            'mail_id'
                            ];

    public function getMailAttachmentAttribute()
    {
        return route('mail_attachment', str_replace('app/mail_attachment/', '', $this->filename));
    }
}
