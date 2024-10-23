<div>

    @if(!$responseText)
    <div class="flex w-full mt-8 px-4">
        <div class="flex flex-col md:flex-row">
            <h1 class="text-xl font-bold sm:text-base dark:text-white mb-2 md:mb-0"><i><s>RTFM</s></i> Let me read that for you</h1>
        </div>
    </div>

    <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
    <div class="flex items-center justify-center w-full lg:mt-12 lg:px-12 sm:mt-8 sm:px-8 mt-4 px-4">
        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">PDF files only (MAX. 32MB)</p>

                
                @error('file') <span class="text-red-500">{{ $message }}</span> @enderror


                
    @if($file)
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">Selected file: <span class="font-semibold">{{ $fileName }}</span></p>
    </div>
    @endif


            </div>
            <input id="dropzone-file" type="file" class="hidden" wire:model="file" />
        </label>
    </div>
    <div class="flex justify-center lg:p-12 sm:p-8 p-4">
        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 relative">
           <span wire:loading.remove wire:target="uploadFile">Do the magic ✨</span>
           <span wire:loading wire:target="uploadFile">Uploading... <span x-text="$wire.progress"></span>%</span>
           <div wire:loading wire:target="uploadFile" class="absolute bottom-0 left-0 w-full bg-gray-200 rounded-full h-1 dark:bg-gray-700">
               <div class="bg-blue-600 h-1 rounded-full" style="width: 0%" wire:poll.500ms="updateProgressBar"></div>
           </div>
        </button>
    </div>
    </form>

    @endif


        <div class="mt-4 py-4 ">
            <div class="flex w-full mt-3 px-4">
              <div class="bg-white shadow-md p-4 w-full print-me">
                  <h2 class="text-xl font-semibold mb-4 dark:text-gray-800 flex justify-between items-center">
                    <span>Summary</span>

                    @if($responseText)
                    <div class="flex items-center space-x-2">

                        <button class="text-gray-600 hover:text-gray-800 exclude-print" onclick="printOnlyMe()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>

                        <span class="text-sm text-gray-600 cursor-pointer exclude-print" wire:click="resetFile">
                            <b>X</b>
                        </span>

                    </div>
                    @endif
                  </h2>
                  <p class="text-sm text-gray-600 whitespace-pre-line">{{ $responseText ?? 'Please upload a file first.' }}</p>

                  @if($questionAnswer)
                  <p class="text-sm text-gray-600 whitespace-pre-line">{!! $questionAnswer !!}</p>
                  @endif
              </div>
            </div>
        </div>



        
        @if($responseText)
        <div class="mt-4 px-4 py-8">
            <form wire:submit.prevent="askQuestion" class="flex items-center">
                <input 
                type="text" 
                wire:model.defer="question" 
                placeholder="Ask anything about the PDF..." 
                class="flex-grow p-2 text-black"
                x-data="{}"
                x-on:keydown.enter="$wire.askQuestion().then(() => { $el.value = ''; })"
                x-ref="questionInput"
            />
            
            <button 
                wire:click="$wire.askQuestion().then(() => { $refs.questionInput.value = ''; })"
                type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
            >
                
                    <span wire:loading.remove wire:target="askQuestion">Ask</span>
                    <span wire:loading wire:target="askQuestion">Generating...</span>
                </button>
            </form>
        </div>
        @endif

       

</div>


<script>
    function printOnlyMe() {
        var printContents = document.querySelector('.print-me').innerHTML;
        var originalContents = document.body.innerHTML;

        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = printContents;

        var excludePrintElements = tempDiv.querySelectorAll('.exclude-print');
        excludePrintElements.forEach(function(element) {
            element.remove();
        });

        document.body.innerHTML = tempDiv.innerHTML;

        window.print();

        document.body.innerHTML = originalContents;
    }
    </script>
