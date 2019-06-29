<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * SEEDER FOR ROLES
         * */
        $default_roles = ['admin', 'teacher', 'medical', 'disciplinarian'];

        foreach ($default_roles as $role) {
            \App\DB\System\Role::create([
                'label' => $role,
                'description' => ucwords($role)
            ]);
        }

        /*
         * SEEDING THE DEFAULT ADMIN
         * */
        if($roleAdmin = \App\DB\System\Role::where('label', 'admin')->first()) {
            $defaultAdmin = [
                'role_id' => $roleAdmin->id,
                'name' => "Lydia Wairimu",
                'email' => "rugurulydiah@gmail.com",
                'password' => \Illuminate\Support\Facades\Hash::make('wairimu4'),
            ];

            \App\User::create($defaultAdmin);
        }

        /*
         * SEEDER FOR SUBJECTS
         * */
        $subjects = ['maths', 'english', 'kiswahili', 'chemistry', 'physics', 'biology', 'history', 'geography', 'CRE', 'business studies', 'agriculture'];
        foreach ($subjects as $subject) {
            \App\DB\Academics\Subject::create([
                'label' => $subject
            ]);
        }
    }
}
