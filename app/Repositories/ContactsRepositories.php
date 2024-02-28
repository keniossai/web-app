<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\ContactRel;
use Illuminate\Support\Facades\DB;

class ContactsRepositories
{
    public static function getContacts($project)
    {
        $ids_contact = ContactRel::where([
            'type_element' => 'project',
            'type_rel' => 'marketing_business_development',
            'element_id' => $project->id_project,
            'deleted' => 0
        ])->pluck('id_contact')->unique();

        return Contact::whereIn('id_contact', $ids_contact)->where('deleted', 0)->orderBy('name')->get();
    }

    public static function getContactsPBD($project)
    {
        $ids_contact = ContactRel::where([
            'type_element' => 'project',
            'type_rel' => 'marketing_business_development',
            'element_id' => $project->id_project,
            'deleted' => 0
        ])->pluck('id_contact')->unique();

        $result = DB::table('contact')
            ->select(
                'id_contact',
                DB::raw("CONCAT(name, ' ', last_name) as name")
            )
            ->whereIn('id_contact', $ids_contact)
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

        $result = $result->toArray();
        array_unshift($result, (object)['id_contact' => '', 'name' => '']);

        return $result;
    }

    public static function getContactsByClient($project)
    {
        $ids_contact = ContactRel::where([
            'type_element' => 'client',
            'type_rel' => 'marketing_business_development',
            'element_id' => $project->id_client,
            'deleted' => 0
        ])->pluck('id_contact')->unique();

        $result = DB::table('contact')
            ->select(
                'id_contact',
                DB::raw("CONCAT(name, ' ', last_name) as custom_name"),
                'name',
                'last_name',
                'type',
                'email',
                'phone',
                'description',
                'no_contact'
            )
            ->whereIn('id_contact', $ids_contact)
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

        $result = $result->toArray();
        array_unshift($result, (object)['id_contact' => '', 'custom_name' => '', 'name' => '', 'last_name' => '', 'type' => '', 'email' => '', 'phone' => '', 'description' => '', 'no_contact' => '']);

        return $result;
    }

    public static function getAllContactsByClient($id_client)
    {
        $ids_contact = ContactRel::where([
            'type_element' => 'client',
            'element_id' => $id_client,
            'deleted' => 0
        ])->pluck('id_contact')->unique();

        return Contact::whereIn('id_contact', $ids_contact)->where('deleted', 0)->orderBy('name')->get();
    }

    public static function getAllContactsMBD()
    {
        $ids_contact = ContactRel::where([
            'type_element' => 'client',
            'type_rel' => 'marketing_business_development',
            'deleted' => 0
        ])->pluck('id_contact')->unique();

        $result = DB::table('contact')
            ->select(
                'id_contact',
                DB::raw("CONCAT(name, ' ', last_name) as custom_name"),
                'name',
                'last_name',
                'type',
                'email',
                'phone',
                'description',
                'no_contact'
            )
            ->whereIn('id_contact', $ids_contact)
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

        $result = $result->toArray();
        array_unshift($result, (object)['id_contact' => '', 'custom_name' => '', 'name' => '', 'last_name' => '', 'type' => '', 'email' => '', 'phone' => '', 'description' => '', 'no_contact' => '']);

        return $result;
    }
}
