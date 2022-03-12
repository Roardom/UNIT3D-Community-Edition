<x-panel heading="Chatbox - change this">
    <chatbox :user="{{ App\Models\User::with(['chatStatus', 'chatroom', 'group'])->find(auth()->id()) }}"></chatbox>
</x-panel>