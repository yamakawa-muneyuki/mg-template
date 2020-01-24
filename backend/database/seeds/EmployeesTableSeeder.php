<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Employee;
        $model->user_id = 2;
        $model->first_name = '太郎';
        $model->last_name = 'ＭＧ';
        $model->save();
    }
}
