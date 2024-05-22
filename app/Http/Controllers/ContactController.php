<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact' => 'required|string|max:255',
            'message' => 'required|string',
            'inventory_number' => 'nullable|string|max:255',
            'inventory_name' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
        ]);

        // Create a new contact record
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'message' => $request->message,
            'inventory_number' => $request->inventory_number,
            'inventory_name' => $request->inventory_name,
            'floor' => $request->floor,
        ]);

        // Return a success response
        return response()->json(['message' => 'Contact Us information sent'], 200);
    }
}
