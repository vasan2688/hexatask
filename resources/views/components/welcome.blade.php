
<div class="flex mt-20 justify-center mt-5 mb-5">
    <div class="ring-1 ring-slate-700/10 rounded-md p-5 shadow-black/5">

        <div class="w-100 bg-white">
            <h1 class="text-2xl flex-auto font-semibold text-slate-900">
                
            </h1>
        </div>
   
        @if ($message = Session::get('success'))
        @php $path = Session::get('path'); @endphp
            <div class="mt-3 flex p-3 mb-2 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <svg aria-hidden="true" class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Success alert! </span>{{ $message }}<br>
                    <span class="font-medium"><a href="{{$path}}">File Destination</a></span>
                </div>
            </div>           

        @endif
       
        @if ($message = Session::get('errors'))

        <div class="mt-3 flex p-3 mb-2 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <svg aria-hidden="true" class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Error alert! </span>{{ $message }}
            </div>
        </div>           

        @endif
      
        <form action="{{ route('file.upload')}}" method="POST" enctype="multipart/form-data" class="mt-5">
            @csrf

            <input type="file" name="file" id="inputImage" multiple class="@error('file') is-invalid @enderror inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150" />
            
            @error('file')
                <span class="text-danger">{{ $message }}</span>
            @enderror           
            
            <button type="submit" class="inline-flex items-right px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">Upload</button>

        </form>
    </div>
</div>