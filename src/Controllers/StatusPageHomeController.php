<?php

namespace Azuriom\Plugin\StatusPage\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\StatusPage\Models\Checks;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftPing;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftPingException;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftQuery;
use Azuriom\Plugin\StatusPage\xpaw\MinecraftQueryException;

class StatusPageHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        return view('statuspage::index', ['checks' => Checks::orderBy('position')->get()]);
    }

    public function check(): void
    {
        $delay = '1';
        $checks = Checks::where('is_enabled', true)->get();
        foreach ($checks as $check) {
            if ($check->updated_at->diffInMinutes() > $delay) {
                if ($check->type === 'java')
                {
                    $this->java($check->host, $check->port, $check);
                }
                else if ($check->type === 'bedrock')
                {
                    $this->bedrock($check->host, $check->port, $check);
                }
            }
        }
    }
    private function java($host, $port, $check)
    {
        try
        {
            $query = new MinecraftPing($check->host, $check->port, 1);
            $status = $query->Query();
            if ($status != '')
            {
                $check->update([
                    'status' => true, //Online
                ]);
            }
            else
            {
                $check->update([
                    'status' => false, //Offline
                ]);
            }
        }
        catch (MinecraftPingException $e)
        {
            $check->update([
                'status' => false, //Offline
            ]);
            $check->update([
                'status' => false, //Offline
            ]);
        }
        finally
        {
            if ($query)
            {
                $query->close();
            }
        }
    }

    public function bedrock($host, $port, $check)
    {
        $query = new MinecraftQuery();
        try
        {
            $query->ConnectBedrock($check->host, $check->$port, 1);
            $check->update([
                'status' => true, //Online
            ]);
        }
        catch (MinecraftQueryException $e)
        {
            $check->update([
                'status' => false, //Offline
            ]);
        }
    }
}
