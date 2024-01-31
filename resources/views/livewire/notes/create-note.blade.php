<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;

    public function validationAttributes()
    {
        return [
            'noteTitle' => 'Titulo',
            'noteBody' => 'Mensagem',
            'noteRecipient' => 'Destinatário',
            'noteSendDate' => 'Data de Envio',
        ];
    }
    
    public function submit()
    {
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
    ]);
        auth()->user()->notes()->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'send_date' => $this->noteSendDate,
            'recipient' => $this->noteRecipient,
            'is_published' => false,
    ]);
        redirect(route('notes.index'));
        dd($this->noteTitle, $this->noteBody, $this->noteRecipient, $this->noteSendDate);
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
        <x-input label="Titulo da Nota" wire:model='noteTitle' placeholder="It's been a great day." />
        <x-textarea label="Sua mensagem" wire:model='noteBody' placeholder="Share all your thoughts with your friend." />
        <x-input icon='envelope' label="Destinatário" wire:model='noteRecipient' placeholder="yourfriend@email.com" />
        <x-input icon='calendar-days' label="Data de Envio" wire:model='noteSendDate' type="date" />
        <div class="flex pt-4">
            <x-button icon="calendar" type="submit">Enviar</x-button>
        </div>
    </form>
</div>
