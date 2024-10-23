<?php

namespace App\Livewire\Pdfread;

use Livewire\Component;

class Chat extends Component    
{
    public $id;

    public function index($id){
        $this->id = $id;
    }
    public function render()
    {
        return view('livewire.pdfread.chat');

    }
}
