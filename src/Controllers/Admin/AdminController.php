<?php

namespace Azuriom\Plugin\StatusPage\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\StatusPage\Models\Checks;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftPing;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftPingException;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftQuery;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftQueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        $servers = Checks::orderBy('position')->get();

        return view('statuspage::admin.index', ['checks' => $servers]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:30',
            'host' => 'required|max:255',
            'port' => 'nullable|integer|min:1,max:65535',
            'type' => 'required|max:255',
        ]);

        Checks::create($validatedData);
//        $statusPageServer = new StatusPageServer();
//        $statusPageServer->name = $validatedData['name'];
////        $statusPageServer->position = $validatedData['position'];
////        $statusPageServer->is_enabled = $request->has('is_enabled');
//        $statusPageServer->host = $validatedData['host'];
//        $statusPageServer->port = $validatedData['port'];
//        $statusPageServer->type = $validatedData['type'];
//        $statusPageServer->save();

        return redirect()->route('statuspage.admin.index');
    }

    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'statusMembers' => ['required', 'array'],
        ]);

        $checks = $request->input('statusMembers');

        $position = 1;

        foreach ($checks as $checkID) {
            Checks::whereKey($checkID)->update(['position' => $position++]);
        }

        return response()->json([
            'message' => 'Check Tests order updated.',
        ]);
    }
    public function create()
    {
        return view('statuspage::admin.create', [
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    public function disable(Request $request)
    {
        $checkID = $request->checkID;
        Checks::whereKey($checkID)->update(
            [
                'is_enabled' => false
            ]
        );
        return redirect()->route('statuspage.admin.index')
            ->with('success', 'Server disabled.');
    }

    public function enable(Request $request)
    {
        $checkID = $request->checkID;
        Checks::whereKey($checkID)->update(
            [
                'is_enabled' => true
            ]
        );
        return redirect()->route('statuspage.admin.index')
            ->with('success', 'Server enabled.');
    }

    /*
        * Show the form for editing the specified resource.
        *
        * @param  \Azuriom\Plugin\StatusPage\Models\Checks $check
        * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {
        $check = Checks::whereKey($request->checkID)->first();
        return view('statuspage::admin.edit', ['server' => $check]);
    }
    public function update(Request $request)
    {
        $check = Checks::whereKey($request->checkID);
        $validatedData = $request->validate([
            'name' => 'required|max:30',
            'host' => 'required|max:255',
            'port' => 'nullable|integer|min:1,max:65535',
            'type' => 'required|max:255',
        ]);
        $check->update($validatedData);
        return redirect()->route('statuspage.admin.index')
            ->with('success', 'Server updated.');
    }

}
