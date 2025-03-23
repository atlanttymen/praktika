<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('tasks')->delete();

        DB::table('tasks')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Крутая таска',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium impedit reprehenderit earum excepturi tempore corporis sequi placeat mollitia labore eos, exercitationem vitae dolorem veritatis itaque! Quibusdam expedita illo id debitis illum consectetur, adipisci quam facere error tempore, impedit sapiente aspernatur praesentium unde consequatur. Possimus eos autem optio exercitationem veritatis quae, aperiam voluptatem ad excepturi dignissimos officiis iure, tempore officia earum cumque. Provident necessitatibus impedit laudantium ullam, ut neque eius a aliquam, esse nemo quo suscipit ad dicta magni officiis vero.',
                    'deadline' => '2025-02-05',
                    'status' => 'Активно',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Не очень такая таска',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit labore iste minus suscipit qui iure, delectus maiores veniam ut hic ipsa sed modi minima fuga reprehenderit! Dolorum commodi unde, ipsa doloremque ducimus ratione mollitia repellendus cupiditate veritatis!',
                    'deadline' => '2025-02-20',
                    'status' => 'Завершено',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                2 =>
                array(
                    'id' => 3,
                    'name' => 'Плохая таска',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci quae, labore vitae atque asperiores praesentium deserunt, officiis voluptatibus eveniet eius deleniti illum, facere vel laudantium repellendus reiciendis delectus animi voluptatem quisquam saepe aspernatur quia ipsam sunt nam! Asperiores sint sunt nulla, veniam, eveniet soluta autem, commodi id est provident esse?',
                    'deadline' => '2025-02-21',
                    'status' => 'Ожидание',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
        ));


    }
}