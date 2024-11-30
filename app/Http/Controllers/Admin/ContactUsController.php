<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\DataTables\ContactUsDataTable;

class ContactUsController extends Controller
{
    public function index(ContactUsDataTable $dataTable) {
        return $dataTable->render('admin.contactus.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        print_r($contactUs->toArray());die;
        return view('admin.contactus.show', compact('contact_us'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contact_us)
    {
        // print_r($contact_us->toArray()); 
        // die("here");
        $contact_us->delete();
        return redirect()->route('admin.contact-us.index')->with('success', 'Contact Us deleted successfully');
    }
}