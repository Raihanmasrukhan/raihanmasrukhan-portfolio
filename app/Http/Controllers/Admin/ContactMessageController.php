<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of inbox contact messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->has('filter') && $request->filter === 'unread') {
            $query->where('is_read', false);
        }

        $messages = $query->paginate(20)->withQueryString();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified message and mark as read.
     */
    public function show(ContactMessage $contactMessage)
    {
        if (! $contactMessage->is_read) {
            $contactMessage->is_read = true;
            $contactMessage->save();
        }

        return view('admin.messages.show', compact('contactMessage'));
    }

    /**
     * Mark message as read/unread toggle.
     */
    public function toggleRead(ContactMessage $contactMessage)
    {
        $contactMessage->is_read = ! $contactMessage->is_read;
        $contactMessage->save();

        return back()->with('success', 'Status pesan berhasil diubah.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
