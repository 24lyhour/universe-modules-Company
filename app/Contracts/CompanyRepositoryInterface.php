<?php

namespace Modules\Company\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Company\Models\Company;

interface CompanyRepositoryInterface
{
    /**
     * Get all companies.
     */
    public function all(): Collection;

    /**
     * Get paginated companies.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find a company by ID.
     */
    public function find(int $id): ?Company;

    /**
     * Find a company by slug.
     */
    public function findBySlug(string $slug): ?Company;

    /**
     * Create a new company.
     */
    public function create(array $data): Company;

    /**
     * Update a company.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a company.
     */
    public function delete(int $id): bool;

    /**
     * Get active companies.
     */
    public function getActive(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get companies by industry.
     */
    public function getByIndustry(string $industry, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get companies by city.
     */
    public function getByCity(string $city, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get companies by user ID.
     */
    public function getByUserId(int $userId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Search companies by name.
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator;
}
