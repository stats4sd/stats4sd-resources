<input 
    type="text" 
    class="{{ $inputClass }}"
    placeholder="Search here"
    wire:model="query"
    wire:keydown.enter="search"
>
