<?php

use Carbon\Carbon;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $title = '';
    public $body = '';
    public $send_date = '01/30/2024';

    public function save()
    {
        Auth::user()
            ->notes()
            ->create([
                'title' => $this->title,
                'body' => $this->body,
                'send_date' => $this->send_date,
            ]);
    }
    public function with()
    {
        return [
            'notes' => Auth::user()
                ->notes()
                ->orderBy('send_date', 'asc')
                ->get(),
        ];
    }
}; ?>

<div>
    <x-input label="Title" wire:model='title' />
    <x-textarea label="Body" wire:model='body' />
    <x-button wire:click="save">TallStackUi</x-button>

    <hr>
    <h1>Notas</h1>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($notes as $note)
            <x-card wire:key='{{ $note->id }}'>
                <div class="flex justify-between">
                    <div class="text-xs text-gray-500">
                        {{ Carbon::parse($note->send_date)->format('M-d-Y') }}
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-xs">Recipient: <span class="font-semibold">Recipient</span></p>
                    <p class="text-xs">title: <span class="font-semibold">{{ $note->title }}</span></p>
                </div>
            </x-card>
        @endforeach
    </div>

</div>
