# Simple Rest API using Laravel5 and NeoEloquent OGM utilizing Neo4j Graph database

## Instructions to run the api:

1. install neo4j via docker by running following in terminal:
  ```
    docker run -d --name neo4j \
    --publish=7474:7474 --publish=7473:7473 --publish=7687:7687 \
    --volume=$HOME/neo4j/data:/data \
    --volume=$HOME/neo4j/logs:/logs \
    neo4j
```
2. run ``http://localhost:7474`` in your browser to make sure neo4j instance is running
3. clone the git repo, run ``composer install`` and update ``.env`` file with your local neo4j user/name and password
4. run ``php artisan neo4j:migrate`` to run database migrations (neo4j is schemaless db, migrations are just adding index and unique properties to the nodes).
5. run ``php artisan db:seed`` to populate the database.
6. run ``php artisian up`` and ``php artisian serve``.
7. Switch back to browser to Neo4j visualizer and run following Cypher query to get doctors that have appointments with patients ``MATCH (p:Patient)-[r1:APPOINTMENT]->(a:Appointment)-[r2:WITH]->(d:Doctor) RETURN p,a,d,COUNT(r2) AS c ORDER BY c LIMIT 25``. Pick a doctor node, copy it's email and password to authenticate the doctor via API. A POST request to ``http://localhost:8000/api/v1/authenticate`` would return back a token. You can use that token to make api calls to available routes.
