<?php

use Illuminate\Database\Seeder;
use Everyman\Neo4j\Cypher\Query;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // clear the data
        $client = DB::connection('neo4j')->getClient();
        $query   = new Query($client, 'MATCH (n) DETACH DELETE n');
        $query->getResultSet();

        $this->call(DoctorsLabelSeeder::class);
        $this->call(PatientsLabelSeeder::class);
    }
}
