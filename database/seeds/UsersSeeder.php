<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = ['Dariusz', 'Magdalena', 'Justyna', 'Paweł', 'Beata', 'Zbigniew', 'Barbara', 'Edward', 'Grażyna', 'Zdzisław', 'Damian'];
        shuffle($users);

        DB::table('users')->insert([
            'name' => 'Dawid',
            'email' => 'testAdmin@test.pl',
            'password' => Hash::make('mojehaslo'),
            'roles' => 'superadmin',
            'hasTaken' => 0
        ]);

        for($i=0; $i<count($users); $i++) {
            DB::table('users')->insert([
                'name' => $users[$i],
                'email' => 'test'.$i.'@test.pl',
                'password' => Hash::make('qwerty'),
                'roles' => null,
                'hasTaken' => 0
            ]);
        }
    }
}
