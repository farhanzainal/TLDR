<?php

namespace App\Livewire\Pdfread;
use Livewire\WithFileUploads;
use Livewire\Component;

class Index extends Component
{
    use WithFileUploads;

    public $file;
    public $progress = 0;

    public function updateProgressBar()
    {
        // This method will be called every 500ms by the wire:poll directive
        // You can update the progress here based on the actual upload progress
        // For now, we'll simulate progress
        if ($this->progress < 100) {
            $this->progress += 10;
        }
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
         
           return redirect()->route('chat', ['id' => $result['sourceId']]);
       } catch (\Exception $e) {
           // Handle any errors
           $this->addError('file', 'Error uploading file: ' . $e->getMessage());
           $this->progress = 0; // Reset progress on error
       }
    }
   

    public function render()
    {
        return view('livewire.pdfread.index')->layout('components.layout');
    }
}
