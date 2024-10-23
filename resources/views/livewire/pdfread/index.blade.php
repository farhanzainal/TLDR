<div>

    @if(!$responseText)
    <div class="flex items-center justify-center w-full mt-8">
        <h1 class="text-xl font-bold sm:text-base">TL;IDFR (I dont fucking read)</h1>
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

    @if($responseText)

        <div class="mt-4 py-4">
            <div class="flex w-full mt-3 px-4">
              <div class="bg-white shadow-md p-4 w-full">
                  <h2 class="text-xl font-semibold mb-4 dark:text-gray-800">Summary</h2>
                  <p class="text-sm text-gray-600 whitespace-pre-line">{{ $responseText ?? 'No summary available yet.' }}
                  </p>
              </div>
            </div>
        </div>
        <div class="flex justify-center mt-2 mb-5">
            <button wire:click="resetFile" class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                &lt; Back
            </button>
        </div>
    @endif
</div>
