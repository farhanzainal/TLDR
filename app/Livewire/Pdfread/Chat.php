<?php

namespace App\Livewire\Pdfread;

use Livewire\Component;
use GuzzleHttp\Client;

class Chat extends Component    
{
    public $id;
    public $newMessage;
    public $messages = [];

    public function sendMessage()
    {
        if (empty($this->newMessage)) {
            return;
        }

        // Add user message to the messages array
        $this->messages[] = ['role' => 'user', 'content' => $this->newMessage];

        $apiKey = env('CHATPDF_API_KEY');
        $url = 'https://api.chatpdf.com/v1/chats/message';

        $client = new Client();

        $response = $client->post($url, [
            'headers' => [
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'sourceId' => $this->id,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->newMessage,
                    ],
                ],
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        // Add AI response to the messages array
        $this->messages[] = ['role' => 'assistant', 'content' => $result['content']];

        $this->newMessage = '';
    }

    public function mount($id)
    {
        $this->id = $id;
    }
    
    public function render()
    {
        return view('livewire.pdfread.chat', ['messages' => $this->messages])->layout('components.layout');
    }
}
