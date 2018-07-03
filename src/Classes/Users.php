<?php

namespace Fessnik\Zoom\Classes;

use Fessnik\Zoom\Http\Request;


/**
 * Class Users
 * @package Fessnik\Zoom\Classes
 *
 */
class Users extends Request
{

    /**
     * Create
     *
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        return $this->post('users', $data);
    }

    /**
     * Get Users
     *
     * @return array
     */
    public function list() : array
    {
        return $this->get('users');
    }

    /**
     * Update
     *
     * @param string $userId
     * @param array $data
     * @return array|mixed
     */
    public function update(string $userId, array $data)
    {
        return $this->patch("users/{$userId}", $data);
    }

    /**
     * Retrieve
     *
     * @param string $userId
     * @param array $optional
     * @return array|mixed
     */
    public function retrieve(string $userId, $optional = [])
    {
        return $this->get("users/{$userId}", $optional);
    }

    public function remove(string $userId)
    {
        return $this->delete("users/{$userId}");
    }

}