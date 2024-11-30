<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use App\Models\Setting;
use GoogleTranslate;
use App\Models\Language;


use App\DataTables\SettingDataTable;

class SettingController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     */
    // 
    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('admin.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'value' => 'required',
            'slug' => 'required|unique:settings',
            'image' => 'nullable|image',
            'is_static' => 'boolean',
        ]);
        $validatedData['slug'] = $this->getUniqueSlug( $validatedData['title']);
        if ($request->hasFile('image')) {
             $validatedData['image'] = $this->verifyAndUpload($request, 'image', null, 'settings');
        }
        $languages = Language::where('status', 1)->get();

        foreach ($languages as $language) {
            if ($language->short_name === 'en') {
                $langId = 'en';

                $settingData = [
                    'title' => $validatedData['title'],
                    'value' => $validatedData['value'],
                    'image' => $validatedData['image'],
                    'slug' => $validatedData['slug'],
                    'lang_id' => $langId,
                ];
                if (array_key_exists('is_static', $validatedData)) {
                    $settingData['is_static'] = $validatedData['is_static'];
                }
            } 
            else {
                $langIds = 'ar';
                $translatedTitle = GoogleTranslate::trans($validatedData['title'],  $langIds);
                $translatedDesc = GoogleTranslate::trans($validatedData['value'],  $langIds);
                $translateedslug = GoogleTranslate::trans($validatedData['slug'],  $langIds);
                

                $settingData = [
                    'title' => $translatedTitle,
                    'value' => $translatedDesc,
                    'image' => $validatedData['image'],
                    'slug' => $translateedslug,
                    'lang_id' =>  $langIds,
                ];
                if (array_key_exists('is_static', $validatedData)) {
                    $settingData['is_static'] = $validatedData['is_static'];
                }
            }
            Setting::create($settingData);

        }

      
        
        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'value' => 'required|string',
            'value_ar' => 'required|string',
            'slug'  => '',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 

        ]);

        // Upload the image
        if($request->hasFile('image')){
            $data['image'] = $this->verifyAndUpload($request, 'image', null, 'settings');
        }
        if($request->hasFile('image_ar')){
            $data['image_ar'] = $this->verifyAndUpload($request, 'image_ar', null, 'settings');
        }

       
        $setting->update($data);
        
        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'setting deleted successfully.');
    }


    protected function getUniqueSlug($title)
    {
        $slug = Str::slug($title); // Generate the slug

        // Check if the slug is already taken
        $count = Setting::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1); 
        }

        return $slug;
    }
}
