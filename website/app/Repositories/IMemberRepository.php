<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface IMemberRepository
{

    /**
     * Creates members on external resource
     * @param $data
     * @return array
     */
    public function create($data): array;

    /**
     * Gets the member list from the external resource
     * @return mixed
     */
    public function list();

    /**
     * Creates a new member into the database that is going to be uploaded in the next upload iterations
     * @param $data
     * @return mixed
     */
    public function addToWaitingList($data);

    /**
     * Deletes the records from the waiting list (database)
     * @param Collection $members
     * @return mixed
     */
    public function syncDone(Collection $members);
}
