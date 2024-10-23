<?php

namespace App\Livewire\Pdfread;
use Livewire\WithFileUploads;
use Livewire\Component;
use GuzzleHttp\Client;

class Index extends Component
{
    use WithFileUploads;

    public $file;
    public $progress = 0;
    public $fileName;

    public $responseText;

    public function updateProgressBar()
    {
        if ($this->progress < 100) {
            $this->progress += 10;
        }
    }
    
    public function resetFile()
    {
        $this->responseText = null;
        $this->progress = 0;
        $this->file = null;
    }

    public function generateResponse(String $sourceId)
    {

        $content = "Can u tell me what this pdf is about ? and summarize it";

        $apiKey = env('CHATPDF_API_KEY');
        $url = 'https://api.chatpdf.com/v1/chats/message';

        $client = new Client();
        $response = $client->post($url, [
            'headers' => [
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'sourceId' => $sourceId,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $content,
                    ],
                ],
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        $this->responseText = $result['content'];
    }

    public function uploadFile()
    {
       $this->validate([
        'file' => 'required|file|max:32768|mimes:pdf', // 32MB Max, PDF only
       ]);

       if (!$this->file->getClientOriginalExtension() === 'pdf') {
           $this->addError('file', 'Invalid File Type');
           $this->dispatchBrowserEvent('show-error', ['message' => 'Invalid File Type', 'duration' => 3000]);
           return;
       }
       $apiKey = env('CHATPDF_API_KEY');
       $url = 'https://api.chatpdf.com/v1/sources/add-file';

       $client = new \GuzzleHttp\Client();
       
       try {
           $this->progress = 0; // Reset progress before starting upload

           $response = $client->post($url, [
               'headers' => [
                   'x-api-key' => $apiKey,
               ],
               'multipart' => [
                   [
                       'name'     => 'file',
                       'contents' => fopen($this->file->getRealPath(), 'r'),
                       'filename' => $this->file->getClientOriginalName(),
                   ],
               ],
           ]);

           $result = json_decode($response->getBody()->getContents(), true);
           // Handle the response as needed
           $this->progress = 100; // Set progress to 100% when upload is complete

           $sourceId = $result['sourceId'];
         
           //then generate response
           $this->generateResponse($sourceId);

       } catch (\Exception $e) {
           // Handle any errors
           $this->addError('file', 'Error uploading file: ' . $e->getMessage());
           $this->progress = 0; // Reset progress on error
       }
    }
   

    public function render()
    {
        if($this->file) {
        $this->fileName = $this->file->getClientOriginalName();
        }
        return view('livewire.pdfread.index')->layout('components.layout');
    }
}
