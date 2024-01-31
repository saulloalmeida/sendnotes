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
    <div class="space-y-2">
        @if ($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No notes yet</p>
                <p class="text-sm">Let's create your first note to send.</p>
                <x-button primary icon-right="plus" class="mt-6" href="{{ route('notes.create') }}"
                    wire:navigate>Create
                    note</x-button>
            </div>
        @endif
            <div class="grid grid-cols-3 gap-4">
                @foreach ($notes as $note)
                    <x-card wire:key='{{ $note->id }}'>
                        <div class="flex justify-between">
                            <div class="text-xs text-gray-500">
                                {{ Carbon::parse($note->send_date)->format('M-d-Y') }}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-xs">Recipient: <span class="font-semibold">{{ $note->recipient }}</span></p>
                            {{-- <div>
                        <x-button.circle icon="eye"
                         href="{{ route('notes.view', $note) }}"
                            ></x-button.circle>
                        <x-button.circle icon="trash"
                            wire:click="delete('{{ $note->id }}')"></x-button.circle>
                    </div> --}}
                            <div>
                                <x-button.circle icon="eye"></x-button.circle>
                                <x-button.circle icon="trash"></x-button.circle>
                            </div>
                            <p class="text-xs">title: <span class="font-semibold">{{ $note->title }}</span></p>
                        </div>
                    </x-card>
                @endforeach
            </div>
    </div>
</div>
