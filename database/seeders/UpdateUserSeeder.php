<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id_user' => 2, 'email' => 'akhan@kiddaitken.com'],
            ['id_user' => 3, 'email' => 'acowlishaw@kiddaitken.com',],
            ['id_user' => 4, 'email' => 'aquilici@kiddaitken.com'],
            ['id_user' => 5, 'email' => 'aherdimansyah@kiddaitken.com'],
            ['id_user' => 6, 'email' => 'aarmitage@kiddaitken.com'],
            ['id_user' => 7, 'email' => 'abarrett@kiddaitken.com'],
            ['id_user' => 8, 'email' => 'apedroso@kiddaitken.com'],
            ['id_user' => 9, 'email' => 'aamarasinghe@kiddaitken.com'],
            ['id_user' => 10, 'email' => 'cgillow@kiddaitken.com'],
            ['id_user' => 11, 'email' => 'cthomson@kiddaitken.com'],
            ['id_user' => 12, 'email' => 'cweller@kiddaitken.com'],
            ['id_user' => 13, 'email' => 'clahr@kiddaitken.com'],
            ['id_user' => 14, 'email' => 'cisobata@kiddaitken.com'],
            ['id_user' => 15, 'email' => 'dkidd@kiddaitken.com'],
            ['id_user' => 16, 'email' => 'dgreaves@kiddaitken.com'],
            ['id_user' => 17, 'email' => 'dmestres@kiddaitken.com'],
            ['id_user' => 18, 'email' => 'dzuniga@kiddaitken.com'],
            ['id_user' => 19, 'email' => 'eoddo@kiddaitken.com'],
            ['id_user' => 20, 'email' => 'gfarias@kiddaitken.com'],
            ['id_user' => 21, 'email' => 'ioneill@kiddaitken.com'],
            ['id_user' => 22, 'email' => 'jaitken@kiddaitken.com'],
            ['id_user' => 23, 'email' => 'jwright@kiddaitken.com'],
            ['id_user' => 24, 'email' => 'jmestanza@kiddaitken.com'],
            ['id_user' => 25, 'email' => 'jdsilva@kiddaitken.com'],
            ['id_user' => 26, 'email' => 'jmurta@kiddaitken.com'],
            ['id_user' => 27, 'email' => 'jmullen@kiddaitken.com'],
            ['id_user' => 28, 'email' => 'jhorvath@kiddaitken.com'],
            ['id_user' => 29, 'email' => 'kgorska@kiddaitken.com'],
            ['id_user' => 30, 'email' => 'kledigo@kiddaitken.com'],
            ['id_user' => 31, 'email' => 'knoble@kiddaitken.com'],
            ['id_user' => 32, 'email' => 'lbishop@kiddaitken.com'],
            ['id_user' => 33, 'email' => 'mnadeem@kiddaitken.com'],
            ['id_user' => 34, 'email' => 'mcripsey@kiddaitken.com'],
            ['id_user' => 35, 'email' => 'meyre@kiddaitken.com'],
            ['id_user' => 36, 'email' => 'mgraulund@kiddaitken.com'],
            ['id_user' => 37, 'email' => 'mahmedi@kiddaitken.com'],
            ['id_user' => 38, 'email' => 'nconstantin@kiddaitken.com'],
            ['id_user' => 39, 'email' => 'nsunil@kiddaitken.com'],
            ['id_user' => 40, 'email' => 'nbout@kiddaitken.com'],
            ['id_user' => 41, 'email' => 'pgrey@kiddaitken.com'],
            ['id_user' => 42, 'email' => 'pmestres@kiddaitken.com'],
            ['id_user' => 43, 'email' => 'r.ali@kiddaitken.com'],
            ['id_user' => 44, 'email' => 'rwinter@kiddaitken.com'],
            ['id_user' => 45, 'email' => 'rwainwright@kiddaitken.com'],
            ['id_user' => 46, 'email' => 'rhwainwright@kiddaitken.com'],
            ['id_user' => 47, 'email' => 'sburrows@kiddaitken.com'],
            ['id_user' => 48, 'email' => 'srichards@kiddaitken.com'],
            ['id_user' => 49, 'email' => 'sprizeman@kiddaitken.com'],
            ['id_user' => 50, 'email' => 'vvalles@kiddaitken.com'],
            ['id_user' => 51, 'email' => 'vmorales@kiddaitken.com'],
            ['id_user' => 52, 'email' => 'wanyango@kiddaitken.com']
        ];

        foreach ($data as $item) {
            $user = User::find($item['id_user']);
            if(isset($user)){
                $validator = Validator::make($item, [
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('user')->ignore($user->id),
                    ],
                ]);
                if ($validator->fails()) {
                    // handle validation error
                } else {
                    $user->update([
                        'email' => $item['email']
                    ]);
                    if(isset($user->contact)){
                        $user->contact->update([
                            'email' => $item['email']
                        ]);
                    }
                }
            }
        }

    }
}
