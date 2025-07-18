<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class EmailListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emailLists = EmailList::query()->paginate();

        return view('email-list.index', [
            'emailLists' => $emailLists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', 'file', 'mimetypes:text/plain,text/csv'],
        ]);

       $emails = $this->getEmailsFromCsvFile($request->file('file'));

        DB::transaction(function () use($request, $emails) {
            $emailList = EmailList::query()->create([
                'title' => $request->title,
            ]);

            $emailList->subscribers()->createMany($emails);
        });

        return to_route('email-list.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getEmailsFromCsvFile(UploadedFile $file): array
    {
        $fileHandle = fopen($file->getRealPath(), 'r');
        $items = [];

        while(($row = fgetcsv($fileHandle, null, ';')) !== false) {
            if($row[0] === 'Name' && $row[1] === 'Email'){
                continue;
            }

            $items [] = [
                'name' => $row[0],
                'email' => $row[1]
            ];
        }

        fclose($fileHandle);

        return $items;
    }
}
