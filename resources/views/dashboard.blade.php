@php
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>PromptForge AI</title>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- AlpineJS -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<a href="{{ route('dashboard') }}" class="flex items-center gap-2">
    <img src="{{ asset('../assets/logo.png') }}" 
         alt="PromptForge AI Logo"
         class="h-10 w-auto">

    <span class="text-lg font-bold text-gray-800">
        PromptForge AI
    </span>
</a>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10 px-4" x-data="app()">

<h1 class="text-4xl font-bold text-center mb-2">
PromptForge AI
</h1>

<p class="text-center text-gray-500 mb-10">
Generate powerful AI prompts instantly
</p>

<!-- Generator Box -->

<div class="bg-gray-900 p-6 rounded-xl shadow-xl">

<input
x-model="topic"
placeholder="Example: build website for my startup..."
class="w-full p-3 rounded bg-gray-800 mb-3 outline-none text-white">

<select
x-model="style"
class="w-full p-3 rounded bg-gray-800 mb-3 text-white">

<option value="creative">Creative</option>
<option value="professional">Professional</option>
<option value="futuristic">Futuristic</option>

</select>

<button
@click="generate()"
:disabled="loading"
class="bg-indigo-600 hover:bg-indigo-700 w-full p-3 rounded text-white font-semibold transition">

<span x-show="!loading">Generate Prompt</span>
<span x-show="loading">AI Thinking...</span>

</button>

<textarea
x-model="result"
placeholder="Generated prompt will appear here..."
class="w-full mt-4 p-3 bg-gray-800 rounded h-40 resize-none text-white"></textarea>

<button
@click="copyPrompt()"
class="mt-3 bg-green-600 hover:bg-green-700 w-full p-2 rounded text-white">

Copy Prompt

</button>

</div>

<!-- History -->

<h2 class="mt-10 text-xl font-semibold text-gray-800">
Prompt History
</h2>

<div class="space-y-4 mt-4">

@forelse($history as $item)

<div x-data="{open:false}" class="bg-white p-4 rounded shadow">

<p class="text-gray-700">

<span x-show="!open">
{{ Str::limit($item->content,120) }}
</span>

<span x-show="open">
{{ $item->content }}
</span>

</p>

<button
@click="open=!open"
class="text-indigo-600 text-sm mt-2 hover:underline">

<span x-show="!open">Baca Selengkapnya</span>
<span x-show="open">Tutup</span>

</button>

</div>

@empty

<p class="text-gray-500">
Belum ada prompt.
</p>

@endforelse

</div>

</div>


<script>

function app(){

return{

topic:'',
style:'creative',
result:'',
loading:false,

generate(){

if(!this.topic){

alert("Please enter a prompt idea")
return

}

this.loading=true
this.result=""

fetch('/generate',{

method:'POST',

headers:{
'Content-Type':'application/json',
'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
},

body:JSON.stringify({

topic:this.topic,
style:this.style

})

})

.then(res=>res.json())

.then(data=>{

this.loading=false
this.typeText(data.prompt)

})

},

typeText(text){

let i=0
this.result=""

let typing=()=>{

if(i<text.length){

this.result+=text.charAt(i)
i++

setTimeout(typing,20)

}

}

typing()

},

copyPrompt(){

if(!this.result){

alert("No prompt to copy")
return

}

navigator.clipboard.writeText(this.result)

alert("Prompt copied!")

}

}

}

</script>
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-6xl mx-auto px-4 py-6 text-center">

        <p class="text-sm">
            © {{ date('Y') }} PromptForge AI. All rights reserved.<br>
            Totok Andrianto. XI PPLG B
        </p>

        <p class="text-xs text-gray-500 mt-2">
            Built with Laravel & AI
        </p>

    </div>
</footer>
</body>
</html>