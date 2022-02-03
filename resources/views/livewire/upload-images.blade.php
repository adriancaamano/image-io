<div>
    <div class="max-w-6xl mx-auto" wire:loading.class.delay="opacity-50 pointer-events-none">
        <form wire:submit.prevent="save">
            <div
                class="p-4 w-full text-center bg-white rounded-lg border shadow-md sm:p-8">
                <h3 class="mb-2 text-3xl font-bold text-gray-900">{{ __('Fast image conversion') }}</h3>
                <p class="mb-5 text-base text-gray-500 sm:text-lg">{{ __('Select desire width/s and format, upload your images and convert.') }}</p>
                
                <div class="mb-5">
                    <input type="checkbox" wire:model="width.320" value="320"> 320
                    <input type="checkbox" wire:model="width.640" value="640"> 640
                    <input type="checkbox" wire:model="width.768" value="768"> 768
                    <input type="checkbox" wire:model="width.1024" value="1024"> 1024
                    <input type="checkbox" wire:model="width.1920" value="1920"> 1920
                </div>
    
                <div class="mb-5">
                    <select wire:model="output">
                        <option value="webp">WEBP</option>
                        <option value="jpg">JPG</option>
                        <option value="png">PNG</option>
                    </select>
                </div>

                @unless(count($photos))
                    <div
                        class="relative pt-1"
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="flex justify-center bg-grey-lighter">
                            <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-gray-800 rounded-lg shadow-lg tracking-wide uppercase border border-gray-800 cursor-pointer hover:bg-gray-800 hover:text-white">
                                <svg class="h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" wire:model="photos" class="hidden" multiple />
                            </label>
                        </div>

                        @error('photos.*') <span class="error">{{ $message }}</span> @enderror
            
                        <div x-show="isUploading">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-white bg-gray-800">
                                        {{ __('Uploading') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-gray-800" x-text="progress + '%'"></span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-3 mb-4 text-xs flex rounded bg-gray-300">
                                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gray-800" x-bind:style="'width:' + progress + '%'"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-5 mx-auto max-w-3xl rounded-xl overflow-auto bg-gray-50">
                        <div class="shadow-sm overflow-hidden my-8">
                            <table class="border-collapse table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-gray-400 text-left">{{ __('Image') }}</th>
                                        <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-gray-400 text-left"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($photos as $index => $photo)
                                        <tr class="bg-white">
                                            <td class="border-b border-gray-100 p-4 pl-8 text-gray-500 text-left">{{ $photo->getClientOriginalName() }}</td>
                                            <td class="border-b border-gray-100 p-4 pl-8 text-gray-500 text-right">
                                                <span class="inline-block cursor-pointer" wire:click="delete({{ $index }})">
                                                    <svg class="h-8" xmlns="http://www.w3.org/2000/svg" fill="none"  viewBox="0 0 24 24" stroke="currentColor" >
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-5 flex justify-center">
                        <label class="flex items-center space-x-4 px-6 py-2 bg-white text-gray-800 rounded-lg shadow-lg tracking-wide uppercase border border-gray-800 cursor-pointer hover:bg-gray-800 hover:text-white">
                            <svg class="h-8" xmlns="http://www.w3.org/2000/svg" fill="none"  viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-base leading-normal">{{ __('Add more files') }}</span>
                            <input type="file" wire:model="additional_photos" class="hidden" multiple />
                        </label>
                    </div>

                    <div class="sticky bottom-0">
                        <button class="w-full px-6 py-4 bg-gray-800 text-white rounded-lg shadow-lg tracking-wide uppercase border border-gray-800 cursor-pointer hover:bg-white hover:text-gray-800" type="submit">{{ __('Convert photos') }}</button>
                    </div>
                @endunless
            </div>
        </form>
    </div>
</div>
