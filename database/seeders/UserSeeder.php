<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->createUsers();
        $this->createGroups();
        $this->createGroupsDetails();
    }

    private function createAdmin()
    {
        $user = User::create([
            'email' => 'admin@kiddaitken.com',
            'password' => Hash::make('kidd2022'),
            'email_verified_at' => now()
        ]);

        Contact::create([
            'id_user' => $user->id_user,
            'name' => 'administrator entropy',
            'type' => 'employee',
            'email' => 'admin@kiddaitken.com'
        ]);

        UserRole::create([
            'id_user' => $user->id_user,
            'id_role' => Role::where(['code' => 'admin'])->first()->id_role
        ]);
    }

    private function createUsers()
    {
        User::firstOrCreate(['id_user' => 2, 'email' => 'akhan@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 3, 'email' => 'acowlishaw@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 4, 'email' => 'aquilici@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 5, 'email' => 'aherdimansyah@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 6, 'email' => 'aarmitage@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 7, 'email' => 'abarrett@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 8, 'email' => 'apedroso@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 9, 'email' => 'aamarasinghe@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 10, 'email' => 'cgillow@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 11, 'email' => 'cthomson@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 12, 'email' => 'cweller@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 13, 'email' => 'clahr@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 14, 'email' => 'cisobata@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 15, 'email' => 'dkidd@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 16, 'email' => 'dgreaves@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 17, 'email' => 'dmestres@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 18, 'email' => 'dzuniga@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 19, 'email' => 'eoddo@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 20, 'email' => 'gfarias@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 21, 'email' => 'ioneill@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 22, 'email' => 'jaitken@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 23, 'email' => 'jwright@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 24, 'email' => 'jmestanza@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 25, 'email' => 'jdsilva@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 26, 'email' => 'jmurta@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 27, 'email' => 'jmullen@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 28, 'email' => 'jhorvath@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 29, 'email' => 'kgorska@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 30, 'email' => 'kledigo@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 31, 'email' => 'knoble@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 32, 'email' => 'mnadeem@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 33, 'email' => 'mcripsey@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 34, 'email' => 'meyre@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 35, 'email' => 'mgraulund@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 36, 'email' => 'mahmedi@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 37, 'email' => 'nconstantin@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 38, 'email' => 'nsunil@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 39, 'email' => 'nbout@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 40, 'email' => 'pgrey@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 41, 'email' => 'pmestres@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 42, 'email' => 'r.ali@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 43, 'email' => 'rwinter@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 44, 'email' => 'rwainwright@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 45, 'email' => 'rhwainwright@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 46, 'email' => 'sburrows@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 47, 'email' => 'srichards@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 48, 'email' => 'sprizeman@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 49, 'email' => 'vvalles@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 50, 'email' => 'vmorales@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        User::firstOrCreate(['id_user' => 51, 'email' => 'wanyango@kiddaitken.com','password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);


        Contact::firstOrCreate(['id_user' => 2  ,'name' => 'Alaina', 'last_name'=> 'Khan' , 'type'=> 'employe'  ,'email'=> 'akhan@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 3  ,'name' => 'Alex', 'last_name'=> 'Cowlishaw' , 'type'=> 'employe'  ,'email'=> 'acowlishaw@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 4  ,'name' => 'Alexandra', 'last_name'=> 'Quilici' , 'type'=> 'employe'  ,'email'=> 'aquilici@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 5  ,'name' => 'Alyssa', 'last_name'=> 'Herdimansyah' , 'type'=> 'employe'  ,'email'=> 'aherdimansyah@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 6  ,'name' => 'Angela', 'last_name'=> 'Armitage' , 'type'=> 'employe'  ,'email'=> 'aarmitage@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 7  ,'name' => 'Angela', 'last_name'=> 'Barrett' , 'type'=> 'employe'  ,'email'=> 'abarrett@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 8  ,'name' => 'Angelica', 'last_name'=> 'Pedroso' , 'type'=> 'employe'  ,'email'=> 'apedroso@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 9  ,'name' => 'Ayesh', 'last_name'=> 'Amarasinghe' , 'type'=> 'employe'  ,'email'=> 'aamarasinghe@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 10  ,'name' => 'Catherine', 'last_name'=> 'Gillow' , 'type'=> 'employe'  ,'email'=> 'cgillow@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 11  ,'name' => 'Chloe', 'last_name'=> 'Thomson' , 'type'=> 'employe'  ,'email'=> 'cthomson@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 12  ,'name' => 'Chloe', 'last_name'=> 'Weller' , 'type'=> 'employe'  ,'email'=> 'cweller@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 13  ,'name' => 'Chris', 'last_name'=> 'Lahr' , 'type'=> 'employe'  ,'email'=> 'clahr@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 14  ,'name' => 'Cintia', 'last_name'=> 'Isobata' , 'type'=> 'employe'  ,'email'=> 'cisobata@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 15  ,'name' => 'Daniel', 'last_name'=> 'Kidd' , 'type'=> 'employe'  ,'email'=> 'dkidd@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 16  ,'name' => 'David', 'last_name'=> 'Greaves' , 'type'=> 'employe'  ,'email'=> 'dgreaves@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 17  ,'name' => 'David', 'last_name'=> 'Mestres' , 'type'=> 'employe'  ,'email'=> 'dmestres@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 18  ,'name' => 'Diana', 'last_name'=> 'Zuniga' , 'type'=> 'employe'  ,'email'=> 'dzuniga@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 19  ,'name' => 'Eva', 'last_name'=> 'Oddo' , 'type'=> 'employe'  ,'email'=> 'eoddo@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 20  ,'name' => 'Giseli', 'last_name'=> 'Farias' , 'type'=> 'employe'  ,'email'=> 'gfarias@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 21  ,'name' => 'Ian', 'last_name'=> 'O´Neill' , 'type'=> 'employe'  ,'email'=> 'ioneill@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 22  ,'name' => 'Jacob', 'last_name'=> 'Aitken' , 'type'=> 'employe'  ,'email'=> 'jaitken@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 23  ,'name' => 'James', 'last_name'=> 'Wright' , 'type'=> 'employe'  ,'email'=> 'jwright@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 24  ,'name' => 'Jemma', 'last_name'=> 'Mestanza' , 'type'=> 'employe'  ,'email'=> 'jmestanza@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 25  ,'name' => 'Joanne', 'last_name'=> 'D´Silva' , 'type'=> 'employe'  ,'email'=> 'jdsilva@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 26  ,'name' => 'Johnny', 'last_name'=> 'Murta' , 'type'=> 'employe'  ,'email'=> 'jmurta@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 27  ,'name' => 'Josephine', 'last_name'=> 'Mullen' , 'type'=> 'employe'  ,'email'=> 'jmullen@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 28  ,'name' => 'Julia', 'last_name'=> 'Horvath' , 'type'=> 'employe'  ,'email'=> 'jhorvath@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 29  ,'name' => 'Katarzyna', 'last_name'=> 'Gorska' , 'type'=> 'employe'  ,'email'=> 'kgorska@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 30  ,'name' => 'Kate', 'last_name'=> 'Ledigo' , 'type'=> 'employe'  ,'email'=> 'kledigo@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 31  ,'name' => 'Kate', 'last_name'=> 'Noble' , 'type'=> 'employe'  ,'email'=> 'knoble@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 32  ,'name' => 'Maheen', 'last_name'=> 'Nadeem' , 'type'=> 'employe'  ,'email'=> 'mnadeem@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 33  ,'name' => 'Matthew', 'last_name'=> 'Cripsey' , 'type'=> 'employe'  ,'email'=> 'mcripsey@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 34  ,'name' => 'Matthew', 'last_name'=> 'Eyre' , 'type'=> 'employe'  ,'email'=> 'meyre@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 35  ,'name' => 'Monica', 'last_name'=> 'Graulund' , 'type'=> 'employe'  ,'email'=> 'mgraulund@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 36  ,'name' => 'Mudasser', 'last_name'=> 'Ahmedi' , 'type'=> 'employe'  ,'email'=> 'mahmedi@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 37  ,'name' => 'Natasa', 'last_name'=> 'Constantin' , 'type'=> 'employe'  ,'email'=> 'nconstantin@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 38  ,'name' => 'Neha', 'last_name'=> 'Sunil' , 'type'=> 'employe'  ,'email'=> 'nsunil@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 39  ,'name' => 'Nikita', 'last_name'=> 'Bout King' , 'type'=> 'employe'  ,'email'=> 'nbout@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 40  ,'name' => 'Peter', 'last_name'=> 'Grey' , 'type'=> 'employe'  ,'email'=> 'pgrey@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 41  ,'name' => 'Petra', 'last_name'=> 'Mestres' , 'type'=> 'employe'  ,'email'=> 'pmestres@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 42  ,'name' => 'Raisah', 'last_name'=> 'Ali' , 'type'=> 'employe'  ,'email'=> 'r.ali@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 43  ,'name' => 'Richard', 'last_name'=> 'Winter' , 'type'=> 'employe'  ,'email'=> 'rwinter@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 44  ,'name' => 'Rob', 'last_name'=> 'Wainwright' , 'type'=> 'employe'  ,'email'=> 'rwainwright@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 45  ,'name' => 'Robert', 'last_name'=> 'H Wainwright' , 'type'=> 'employe'  ,'email'=> 'rhwainwright@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 46  ,'name' => 'Sam', 'last_name'=> 'Burrows' , 'type'=> 'employe'  ,'email'=> 'sburrows@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 47  ,'name' => 'Spencer', 'last_name'=> 'Richards' , 'type'=> 'employe'  ,'email'=> 'srichards@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 48  ,'name' => 'Steven', 'last_name'=> 'Prizeman' , 'type'=> 'employe'  ,'email'=> 'sprizeman@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 49  ,'name' => 'Veronica', 'last_name'=> 'Valles' , 'type'=> 'employe'  ,'email'=> 'vvalles@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 50  ,'name' => 'Victoria', 'last_name'=> 'Soria Morales' , 'type'=> 'employe'  ,'email'=> 'vmorales@kiddaitken.com']);
        Contact::firstOrCreate(['id_user' => 51  ,'name' => 'Winnie', 'last_name'=> 'Anyango' , 'type'=> 'employe'  ,'email'=> 'wanyango@kiddaitken.com']);

        UserRole::firstOrCreate(['id_user' => 2, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 3, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 4, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 5, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 6, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 7, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 8, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 9, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 10, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 11, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 12, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 13, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 14, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 15, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='hr_director'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 16, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 17, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 18, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 19, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        // UserRole::firstOrCreate(['id_user' => 20, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='head_of_europe_and_latam'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 21, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 22, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='hr_director'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 23, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 24, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 25, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 26, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 27, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 28, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 29, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 30, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 31, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 32, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 33, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 34, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 35, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 36, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 37, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 38, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 39, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 40, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 41, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 42, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 43, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 44, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 45, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 46, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 47, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 48, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 49, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 50, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='coordinator'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 51, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='lds'")[0]->id_role]);

        UserRole::firstOrCreate(['id_user' => 4, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 8, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 11, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 15, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 19, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 20, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 22, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 30, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 33, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='client_owner'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 37, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);

        UserRole::firstOrCreate(['id_user' => 4, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 11, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 15, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 20, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 22, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 30, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
        UserRole::firstOrCreate(['id_user' => 33, 'id_role' => DB::select("SELECT id_role FROM role WHERE CODE ='senior_consultant'")[0]->id_role]);
    }

    private function createGroups()
    {
        Group::firstOrCreate(['name' => "Team Angelica Pedroso", 'id_group' => 4]);
        Group::firstOrCreate(['name' => "Team Chris Lahr", 'id_group' => 1]);
        Group::firstOrCreate(['name' => "Team Alex Cowlishaw", 'id_group' => 5]);
        Group::firstOrCreate(['name' => "Team Alexandra Quilici", 'id_group' => 9]);
        Group::firstOrCreate(['name' => "Team David Greaves", 'id_group' => 6]);
        Group::firstOrCreate(['name' => "Team Giseli Farias", 'id_group' => 3]);
        Group::firstOrCreate(['name' => "Team Ian O´Neill", 'id_group' => 7]);
        Group::firstOrCreate(['name' => "Team James Wright", 'id_group' => 14]);
        Group::firstOrCreate(['name' => "Team Kate Ledigo", 'id_group' => 10]);
        Group::firstOrCreate(['name' => "Team Matthew Cripsey", 'id_group' => 8]);
        Group::firstOrCreate(['name' => "Team Matthew Eyre", 'id_group' => 11]);
        Group::firstOrCreate(['name' => "Team Rob Wainwright", 'id_group' => 13]);
        Group::firstOrCreate(['name' => "Team Eva Odoo", 'id_group' => 2]);
    }

    private function createGroupsDetails()
    {
        GroupDetail::firstOrCreate(['id_group' => 11, 'id_user' => 2,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 4, 'id_user' => 8,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 5, 'id_user' => 3,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 9, 'id_user' => 4,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 1, 'id_user' => 13,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 7, 'id_user' => 5,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 6, 'id_user' => 16,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 7, 'id_user' => 9,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 3, 'id_user' => 20,'is_admin'=>1]);
        // GroupDetail::firstOrCreate(['id_group' => 12, 'id_user' => 11,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 3, 'id_user' => 12,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 3, 'id_user' => 14,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 13, 'id_user' => 17,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 3, 'id_user' => 19,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 7, 'id_user' => 21,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 14, 'id_user' => 23,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 6, 'id_user' => 24,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 13, 'id_user' => 25,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 10, 'id_user' => 26,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 3, 'id_user' => 28,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 4, 'id_user' => 29,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 10, 'id_user' => 30,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 14, 'id_user' => 32,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 8, 'id_user' => 33,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 11, 'id_user' => 34,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 10, 'id_user' => 35,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 14, 'id_user' => 36,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 10, 'id_user' => 37,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 1, 'id_user' => 38,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 9, 'id_user' => 40,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 9, 'id_user' => 41,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 11, 'id_user' => 43,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 13, 'id_user' => 44,'is_admin'=>1]);
        GroupDetail::firstOrCreate(['id_group' => 6, 'id_user' => 46,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 4, 'id_user' => 47,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 5, 'id_user' => 48,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 1, 'id_user' => 49,'is_admin'=>null]);
        GroupDetail::firstOrCreate(['id_group' => 5, 'id_user' => 51,'is_admin'=>null]);
    }
}
