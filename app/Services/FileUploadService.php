<?php

namespace App\Services\Gallery;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use PDF;

class FileUploadService
{
    protected $options;
    protected $file;
    protected $savedFile;
    
    protected $default_options = [
        'validation' => [
            'max_size' => 5120,
            'format'   => 'pdf'
        ],
        'compression' => 100,
        'watermark'   => false,
        'thumbnail'   => false,
        'save_format' => 'pdf',
        'upload_path' => 'app/mail_attachment'
    ];

    public function __construct($file, $options)
    {
        $this->setOptions($options);
        $this->file = $file;
    }

    public function save()
    {
        $this->validateFile();
        $uuid      =Str::uuid();
        $name      =$this->setFileName($this->options['upload_path'], $uuid, $this->options['save_format']);
       
        //Load PDF
        $pdf = PDF::make($this->file);

        //Add Watermark
        if ($this->options['watermark']) {
            $pdf->insert(public_path('img/poa-logo.png'), 'center');
        }

        //Save PDF
        $pdf->save(storage_path($name), $this->options['compression'], $this->options['save_format']);

        $this->savedFile     = $name;
    }

    public function getSavedFile()
    {
        return  $this->savedFile;
    }

    private function setOptions($options)
    {
        $this->options = array_replace_recursive($this->default_options, $options);
    }

    private function validateFile()
    {
        Validator::make(['file'=>$this->file], [
            'file' => 'required|mimes:' . $this->options['validation']['format'] . '|max:' . $this->options['validation']['max_size']
        ])->validate();
    }

    private function setFileName($path, $name, $ext, $sufix='')
    {
        return $path . '/' . $name . $sufix . '.' . $ext;
    }
}
